FROM php:7.4-fpm

ARG TZ

WORKDIR /code

RUN apt update && \
    apt full-upgrade -y && \
    apt autoremove -y && \
    apt autoclean -y && \
    apt install zip unzip

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

RUN docker-php-ext-install bcmath pdo_mysql tokenizer
