FROM composer:2.10.3 AS composer-base

## base image: FrankenPHP (classic mode) on PHP 8.5.12
FROM dunglas/frankenphp:1.13.2-php8.5.12-bookworm AS base

COPY --from=composer-base /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /code
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY docker/php/zz-custom.ini $PHP_INI_DIR/conf.d/
COPY docker/frankenphp/Caddyfile /etc/frankenphp/Caddyfile

RUN apt-get update && \
    apt-get install -y \
    curl \
    zip \
    unzip \
    locales \
    default-mysql-client

# opcache is built into PHP 8.5 and can no longer be built as a shared extension
RUN install-php-extensions bcmath intl pdo_mysql

STOPSIGNAL SIGTERM

EXPOSE 80

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
COPY --from=composer-cache /code /code

# copy app sources
COPY . ./

# generate autoload files
RUN composer install
