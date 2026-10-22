FROM composer:2.10.3 AS composer-base

## NGINX Unit 1.35.0 built from source on a patched PHP (the official unit:php8.4 image ships an unpatched PHP)
FROM php:8.5.12-cli-bookworm AS unit-build

ARG UNIT_VERSION=1.35.0

RUN set -ex && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        git \
        build-essential \
        libssl-dev \
        libpcre2-dev \
        zlib1g-dev \
        pkg-config && \
    mkdir -p /usr/lib/unit/modules /usr/src/unit && \
    cd /usr/src/unit && \
    git clone --depth 1 -b "${UNIT_VERSION}" https://github.com/nginx/unit && \
    cd unit && \
    NCPU="$(getconf _NPROCESSORS_ONLN)" && \
    DEB_HOST_MULTIARCH="$(dpkg-architecture -q DEB_HOST_MULTIARCH)" && \
    CC_OPT="$(DEB_BUILD_MAINT_OPTIONS="hardening=+all,-pie" DEB_CFLAGS_MAINT_APPEND="-Wp,-D_FORTIFY_SOURCE=2 -fPIC" dpkg-buildflags --get CFLAGS)" && \
    LD_OPT="$(DEB_BUILD_MAINT_OPTIONS="hardening=+all,-pie" DEB_LDFLAGS_MAINT_APPEND="-Wl,--as-needed -pie" dpkg-buildflags --get LDFLAGS)" && \
    CONFIGURE_ARGS="--prefix=/usr \
        --statedir=/var/lib/unit \
        --control=unix:/var/run/control.unit.sock \
        --runstatedir=/var/run \
        --pid=/var/run/unit.pid \
        --logdir=/var/log \
        --log=/var/log/unit.log \
        --tmpdir=/var/tmp \
        --user=unit \
        --group=unit \
        --openssl \
        --zlib \
        --libdir=/usr/lib/${DEB_HOST_MULTIARCH}" && \
    ./configure ${CONFIGURE_ARGS} --cc-opt="${CC_OPT}" --ld-opt="${LD_OPT}" --modulesdir=/usr/lib/unit/modules && \
    make -j "${NCPU}" unitd && \
    install -pm755 build/sbin/unitd /usr/sbin/unitd && \
    make clean && \
    # PHP 8.5 added pre_request_init to sapi_module_struct; Unit 1.35.0 (archived upstream) initializes it positionally, so the missing (NULL) initializer must not be an error
    ./configure ${CONFIGURE_ARGS} --cc-opt="${CC_OPT} -Wno-error=missing-field-initializers" --modulesdir=/usr/lib/unit/modules && \
    ./configure php && \
    make -j "${NCPU}" php-install

## base image: patched PHP + Unit
FROM php:8.5.12-cli-bookworm AS base

COPY --from=unit-build /usr/sbin/unitd /usr/sbin/unitd
COPY --from=unit-build /usr/lib/unit/modules/ /usr/lib/unit/modules/
COPY --from=composer-base /usr/bin/composer /usr/bin/composer
COPY docker/unit/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN set -ex && \
    groupadd --gid 999 unit && \
    useradd --uid 999 --gid unit --no-create-home --home /nonexistent --comment "unit user" --shell /bin/false unit && \
    mkdir -p /var/lib/unit /docker-entrypoint.d && \
    ln -sf /dev/stderr /var/log/unit.log && \
    chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /code
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY docker/unit/zz-custom.ini /usr/local/etc/php/conf.d/

RUN apt-get update && \
    apt-get install -y \
    curl \
    g++ \
    zip \
    unzip \
    locales \
    libicu-dev \
    libmemcached-dev \
    zlib1g-dev \
    libonig-dev \
    libpcre2-8-0 \
    default-mysql-client

RUN export MAKEFLAGS="-j$(nproc)" && \
    docker-php-ext-install -j$(nproc) bcmath intl pdo_mysql opcache

COPY docker/unit/config.json /docker-entrypoint.d/

STOPSIGNAL SIGTERM

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
EXPOSE 80
CMD ["unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]

## composer
FROM composer-base AS composer-cache

WORKDIR /code

# copy only composer files for caching
COPY composer.json composer.lock ./

# install deps(without generating autoloader)
RUN --mount=type=cache,target=/root/.cache/composer/ composer install --no-scripts --no-autoloader --ignore-platform-reqs

## appliation
FROM base

# clean cache
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# copy production config template
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# copy cached composer files
COPY --chown=unit:unit --from=composer-cache /code /code

# copy app sources
COPY --chown=unit:unit . ./

USER unit

# generate autoload files
RUN composer install

USER root
