FROM php:7.1-fpm

RUN apt-get update
RUN apt-get install -y nano mc libicu-dev zlib1g-dev

RUN docker-php-ext-configure zip
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl > /dev/null
RUN docker-php-ext-install mysqli pdo pdo_mysql > /dev/null

COPY www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www