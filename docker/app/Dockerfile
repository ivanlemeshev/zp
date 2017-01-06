FROM php:7.1.0-fpm-alpine

RUN cd /usr/local/bin && curl -sS https://getcomposer.org/installer | php
RUN cd /usr/local/bin && mv composer.phar composer

RUN set -ex && apk --no-cache add libmcrypt-dev

RUN docker-php-ext-install iconv mcrypt
