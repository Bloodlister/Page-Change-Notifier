FROM php:7.4-fpm-alpine

WORKDIR /usr/src/app
RUN apk update && apk add libxml2-dev oniguruma-dev
RUN docker-php-ext-install pdo pdo_mysql xml dom mbstring


