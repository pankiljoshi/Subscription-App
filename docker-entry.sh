#!/bin/sh
php artisan cache:clear &
php artisan config:cache &
php artisan migrate &
php-fpm &
nginx -g "daemon off;"