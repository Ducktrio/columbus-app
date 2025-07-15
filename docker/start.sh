#!/bin/sh

mkdir -p /home/database

chmod -R 664 /var/www/database/database.sqlite
chown -R www-data:www-data /var/www/database/database.sqlite

php artisan migrate --force --seed

export APP_ENV=prod

php-fpm &

nginx -g "daemon off;"
