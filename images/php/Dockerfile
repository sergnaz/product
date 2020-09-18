FROM php:7.4-fpm

MAINTAINER Nazarenko Serhii <serg.progr@gmail.com>

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && apt-get install -y libonig-dev libpq-dev \
    curl \
    wget \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
#    libmcrypt-dev \
    libpng-dev \
#    && docker-php-ext-install -j$(nproc) iconv mcrypt mbstring mysqli pdo_mysql zip \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www

CMD ["php-fpm"]