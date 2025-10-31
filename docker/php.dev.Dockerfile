FROM php:8.3-fpm

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip opcache fileinfo pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /app/vendor && chown -R www:www /app

COPY --chown=www:www composer.json composer.lock ./

USER www

RUN composer install --no-dev --no-scripts --no-autoloader

COPY --chown=www:www . /app

WORKDIR /app