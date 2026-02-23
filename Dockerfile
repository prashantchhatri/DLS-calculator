FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
COPY . .
RUN composer dump-autoload --optimize

FROM node:20-alpine AS frontend

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

FROM php:8.3-cli-alpine

WORKDIR /var/www/html

RUN apk add --no-cache icu-dev oniguruma-dev libzip-dev \
    && docker-php-ext-install intl

COPY --from=vendor /app /var/www/html
COPY --from=frontend /app/public/build /var/www/html/public/build

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD ["sh", "-lc", "php artisan optimize:clear && php artisan storage:link || true; php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]

