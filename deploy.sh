#!/bin/bash

# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Start Apache (or your web server)
apache2-foreground