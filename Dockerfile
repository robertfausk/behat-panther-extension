ARG PHP_VERSION=7.2

FROM composer:2 AS composer
FROM php:${PHP_VERSION}-cli

# replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

RUN apt-get update && apt-get install -y \
    git-core


COPY --from=composer /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /home/docker/.composer
# contains dev-mode packages
RUN composer global config --no-plugins allow-plugins.pyrech/composer-changelogs true
RUN if php -r 'exit(version_compare(PHP_VERSION, "8.0", ">=") ? 0 : 1);'; then \
      composer global require "pyrech/composer-changelogs:^2" --prefer-dist --no-progress --classmap-authoritative; \
    else \
      composer global require "pyrech/composer-changelogs:^1" --prefer-dist --no-progress --classmap-authoritative; \
    fi

##############################################################
# add symfony/panther
##############################################################
RUN apt-get update && apt-get install -y libzip-dev zlib1g-dev unzip chromium && docker-php-ext-install zip
ENV PANTHER_NO_SANDBOX 1

##############################################################
# add gd
##############################################################

RUN apt-get update && apt-get install -y \
    libjpeg-dev \
    libpng-dev

RUN if [[ "${PHP_VERSION}" = "7.4*" ]] || [[ "${PHP_VERSION}" = "8.0*" ]]; then \
    docker-php-ext-configure gd --with-jpeg=/usr/include/ && \
    docker-php-ext-install gd \
    ;el \
    docker-php-ext-configure gd --with-jpeg=/usr/include/ && \
    docker-php-ext-install gd \
    ;fi

RUN git config --global --add safe.directory /var/www/html

RUN composer self-update

WORKDIR /var/www/html
COPY . /var/www/html
