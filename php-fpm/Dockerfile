# docker/php-fpm/Dockerfile

FROM php:fpm-alpine

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it
RUN apk --update --no-cache add git
RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && pecl install xdebug \
        && docker-php-ext-enable xdebug \
        && pecl clear-cache \
        && apk del .build-dependencies
RUN apk add icu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install opcache

COPY ./conf.d/php.ini /usr/local/etc/php/conf.d/php.ini
ADD ./conf.d/php.ini /usr/local/etc/php/php.ini
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apk --no-cache add shadow && \
     usermod -u 1000 --shell /bin/bash www-data && groupmod -g 1000 www-data
USER www-data
WORKDIR /var/www
CMD composer install ; wait-for-it database:3306 -- bin/console doctrine:migrations:migrate ;  php-fpm
EXPOSE 9000
USER 1000:1000
CMD ["php-fpm"]
