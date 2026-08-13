#!/usr/bin/env bash

# Fail immediately if any command fails
set -e

if [ ! -f /var/data/database.sqlite ]; then
    echo "--- Creating fresh SQLite database file ---"
    touch /var/www/html/database/database.sqlite
fi

echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
