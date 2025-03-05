FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the Laravel project files
COPY . .

# Set correct permissions for Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Ensure deploy.sh is copied correctly
COPY deploy.sh /var/www/html/deploy.sh
RUN chmod +x /var/www/html/deploy.sh

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose port 80
EXPOSE 80

# Run the deployment script
CMD ["/var/www/html/deploy.sh"]
