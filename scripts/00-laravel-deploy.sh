#!/usr/bin/env bash

# Fail immediately if any command fails
set -e

if [ ! -f /var/www/html/database/database.sqlite ]; then
    echo "--- Creating fresh SQLite database file ---"
    touch /var/www/html/database/database.sqlite
fi

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
