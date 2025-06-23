FROM php:8.3-apache

# PHP-ext
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Node.js 18 + npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs    

# Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Laravel dependencies
WORKDIR /var/www/html

# Apache document root for public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Turn on mod_rewrite
RUN a2enmod rewrite

# Automation scripts
COPY post-start.sh /var/www/html/post-start.sh
RUN chmod +x /var/www/html/post-start.sh

RUN chown -R www-data:www-data /var/www/html