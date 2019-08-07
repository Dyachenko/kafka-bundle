FROM php:7.3-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apk add build-base librdkafka-dev php7-dev && \
    pecl -q install rdkafka-3.1.2 xdebug-2.7.2 && \
    docker-php-ext-enable rdkafka xdebug && \
    curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
