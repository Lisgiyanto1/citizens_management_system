FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git  \
    curl \
    libpq-dev \
    zip  \
    unzip

RUN docker-php-ext-install pdo pdo_pgsql

RUN pecl install redis && docker-php-ext-enable redis

WORKDIR /var/www