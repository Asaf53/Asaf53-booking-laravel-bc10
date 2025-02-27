# Use PHP 8.2 with FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    zip unzip curl git libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --no-interaction --prefer-dist

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 9000

# Run migrations and seeders before starting PHP-FPM
CMD php artisan migrate --force && \
    php artisan db:seed --class=roles && \
    php artisan db:seed --class=country_city && \
    php artisan db:seed --class=User && \
    php-fpm
