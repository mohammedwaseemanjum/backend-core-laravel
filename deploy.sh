#!/bin/sh

# Fail immediately if any command fails
set -e

echo "🚀 Starting Laravel 12 Deployment Scripts..."

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
