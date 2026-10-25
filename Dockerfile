
# Stage 1: Build frontend assets
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build


# Stage 2: Run Laravel
FROM php:8.2.35-fpm-alpine

# System packages and PHP extensions
RUN apk add --no-cache bash nginx supervisor libpq libzip icu-libs \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS postgresql-dev libzip-dev icu-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql intl zip opcache \
    && apk del .build-deps

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# PHP, PHP-FPM, Nginx and Supervisor configuration
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY conf/php/docker-vars.ini /usr/local/etc/php/conf.d/docker-vars.ini
COPY conf/php/www-overrides.conf /usr/local/etc/php-fpm.d/zz-overrides.conf
COPY conf/nginx/nginx-site.conf /etc/nginx/http.d/default.conf
COPY conf/supervisor/supervisord.conf /etc/supervisord.conf
COPY conf/start.sh /start.sh

RUN chmod +x /start.sh

WORKDIR /var/www/html

# Copy Laravel application
COPY . .

# Add Vite's compiled CSS, JS and manifest
COPY --from=frontend /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

EXPOSE 80

CMD ["/start.sh"]
