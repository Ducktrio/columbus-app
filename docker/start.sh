#!/bin/sh
set -e
service ssh start
export APP_ENV=prod

php-fpm &

nginx -g "daemon off;"
