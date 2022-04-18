FROM php:8.0.17-apache

#install dependencies
RUN apt update && apt install -y \
        nodejs \
        npm \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

#add apache config file
COPY Docker/000-default.conf /etc/apache2/sites-available/000-default.conf

#download composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

#copy and install dependencies
COPY ["composer.json", "composer.lock", "./"]

RUN composer install --no-scripts

#copy rest of files
COPY ["./" , "./"]

#add permissions to www:data user
RUN chown -R www-data:www-data ./ && a2enmod rewrite


