FROM php:8.2-fpm

RUN rm -f /etc/apt/sources.list.d/* && \
        echo 'deb http://mirrors.linode.com/debian/ bookworm main contrib non-free' > /etc/apt/sources.list && \
        echo 'deb-src http://mirrors.linode.com/debian/ bookworm main contrib non-free' >> /etc/apt/sources.list && \
        echo 'deb http://mirrors.linode.com/debian-security/ bookworm-security main contrib non-free' >> /etc/apt/sources.list && \
        echo 'deb-src http://mirrors.linode.com/debian-security/ bookworm-security main contrib non-free' >> /etc/apt/sources.list && \
        echo 'deb http://mirrors.linode.com/debian/ bookworm-updates main contrib non-free' >> /etc/apt/sources.list && \
        echo 'deb-src http://mirrors.linode.com/debian/ bookworm-updates main contrib non-free' >> /etc/apt/sources.list && \
    apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    iputils-ping \
    ca-certificates && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN pecl install xdebug-3.3.2 && docker-php-ext-enable xdebug

COPY docker/php/conf.d/* $PHP_INI_DIR/conf.d/
COPY . /var/www/html

RUN mkdir -p /var/www/html/storage

CMD ["php-fpm"]
