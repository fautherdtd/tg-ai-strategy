FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache php81-pdo_pgsql autoconf g++ make git zip postgresql-dev postgresql-client && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo_pgsql opcache bcmath sockets

COPY ./.docker/php/php.ini /usr/local/etc/php
RUN curl -s https://getcomposer.org/installer | php
RUN alias composer='php composer.phar'

WORKDIR /app
COPY ./ .

#RUN chown -R www-data:www-data .
#RUN chmod -R 755 storage
#USER www-data

CMD ["php-fpm"]
