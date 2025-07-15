#!/bin/sh

export APP_ENV=prod

php-fpm &

nginx -g "daemon off;"
