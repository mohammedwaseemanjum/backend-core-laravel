# Use official PHP 8.2+ CLI image as requested by Laravel 12
FROM php:8.3-cli

# Install system dependencies and PHP extensions required for Laravel 12
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    postgresql-dev \
    linux-headers

RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files first for Docker layer caching
COPY composer.json composer.lock ./

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install production dependencies
RUN composer require turso/libsql-laravel:^0.2.0 turso/libsql:dev-master -W
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set correct permissions for storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN chown -R www-data:www-data /var/www/database
RUN chmod -R 775 /var/www/database

# Make deployment script executable
RUN chmod +x /var/www/deploy.sh

# Copy Nginx configuration
COPY ./nginx.conf /etc/nginx/nginx.conf

# Clear Laravel caches and rediscover packages
RUN php artisan optimize:clear \
    && composer dump-autoload --optimize

# Expose Render's expected port
EXPOSE 80

# Run the deploy script and start Nginx/PHP-FPM
CMD /var/www/deploy.sh && php-fpm -D && nginx -g "daemon off;"
