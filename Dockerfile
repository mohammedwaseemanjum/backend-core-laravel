# Use official PHP 8.3 FPM image (Debian-based)
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    libonig-dev \
    libpq-dev \
    libffi-dev \
    linux-headers-amd64 \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by Laravel
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Configure and install FFI
RUN docker-php-ext-configure ffi --with-ffi \
    && docker-php-ext-install ffi

# Enable FFI
RUN echo "ffi.enable=true" > /usr/local/etc/php/conf.d/ffi.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel application
COPY . /var/www

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# Set Laravel permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN chown -R www-data:www-data /var/www/database \
    && chmod -R 775 /var/www/database

# Make deployment script executable
RUN chmod +x /var/www/deploy.sh

# Copy Nginx configuration
COPY ./nginx.conf /etc/nginx/nginx.conf

# Laravel package discovery
RUN php artisan package:discover --ansi

# Render uses port 80
EXPOSE 80

# Start deployment script, PHP-FPM and Nginx
CMD /var/www/deploy.sh && php-fpm -D && nginx -g "daemon off;"
