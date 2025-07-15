#!/bin/sh

php artisan migrate --force --seed

chmod -R 664 /var/www/database/database.sqlite
chown -R www-data:www-data /var/www/database/database.sqlite

export APP_ENV=prod

php-fpm &

nginx -g "daemon off;"
