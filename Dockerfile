FROM php:8.3-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache nginx wget supervisor bash libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip bcmath opcache

# Configure NGINX and Supervisor
COPY conf/nginx/nginx-site.conf /etc/nginx/http.d/default.conf
COPY conf/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set working directory
WORKDIR /var/www/html
COPY . .

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Setup deployment script permissions
RUN chmod +x /var/www/html/scripts/00-laravel-deploy.sh

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf", "/var/www/html/scripts/00-laravel-deploy.sh"]
