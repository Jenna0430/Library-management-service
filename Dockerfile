# syntax=docker/dockerfile:1

FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite (required by Symfony)
RUN a2enmod rewrite

# Set Apache document root to Symfony public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files

COPY . .

# Install PHP dependencies
RUN composer install --no-scripts --no-interaction --prefer-dist


# Fix permissions
RUN chown -R www-data:www-data var

EXPOSE 80
