FROM php:8.2-fpm

RUN apt-get -y update && apt-get update -y
RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN pecl install xdebug-3.3.2 && docker-php-ext-enable xdebug

COPY docker/php/conf.d/* $PHP_INI_DIR/conf.d/

COPY . /var/www/html

#RUN groupadd -g 1000 t \
#    && useradd -u 1000 -g t -m t

RUN mkdir -p /var/www/html/storage
#&& chown -R t:t /var/www/html/storage

CMD ["php-fpm"]
