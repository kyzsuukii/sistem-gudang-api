FROM composer AS composer

FROM dunglas/frankenphp

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV SERVER_NAME=:80

RUN install-php-extensions pdo_pgsql

COPY . /app

WORKDIR /app

RUN /usr/bin/composer install --optimize-autoloader

RUN cp .env.docker /app/.env

RUN php artisan optimize

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
