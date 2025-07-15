FROM node:18 AS nodebuilder

WORKDIR /app

COPY package*.json vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm ci && npm run build


FROM php:8.2-fpm AS php

RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    sqlite3 \
    libsqlite3-dev \
    tzdata \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        mbstring \
        exif \
        zip \
        intl \
        gd \
        opcache


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


WORKDIR /var/www

COPY . .


COPY --from=nodebuilder /app/public/build /var/www/public/build

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www \
 && chmod -R 775 storage bootstrap/cache



RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache \

RUN php artisan migrate --force --seed

RUN chmod -R 664 /var/www/database/database.sqlite

RUN chown -R www-data:www-data /var/www/database/database.sqlite



COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
