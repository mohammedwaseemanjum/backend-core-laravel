#!/bin/sh

# Fail immediately if any command fails
set -e

if [ ! -f /var/www/database/database.sqlite ]; then
    echo "--- Creating fresh SQLite database file ---"
    touch /var/www/database/database.sqlite
fi

echo "🚀 Starting Laravel 12 Deployment Scripts..."

# Clear old cached configuration
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache configuration, routes, and views for optimal performance
echo "📦 Optimizing Configuration and Routing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Generate storage symlink if it doesn't exist
echo "🔗 Creating storage symlink..."
php artisan storage:link --force

# Run database migrations automatically in production
echo "🗄️ Running database migrations..."
php artisan migrate --force

echo "✅ Deployment optimizations completed successfully!"
