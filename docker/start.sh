#!/bin/sh
set -e
service ssh start

php-fpm &

nginx -g "daemon off;"
