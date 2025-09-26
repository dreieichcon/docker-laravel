#!/bin/bash
set -e

echo "Laravel entrypoint:"

cd /var/www/html

if [ ! -d "vendor" ]; then
    composer install --optimize-autoloader
else
    echo "Vendor directory exists, skipping composer install"
fi


if grep -q "APP_KEY=" .env && ! grep -q "APP_KEY=base64:" .env; then
    echo "Running php artisan key:generate..."
    php artisan key:generate --force
fi

echo "Checking database status..."

if  php artisan docker:database 2>/dev/null | tail -n 1 | grep -q "true" ; then
    echo "Database is ready! Continuing with application startup..."
    # Continue with your normal startup process here
else
    echo "Database check failed. Stopping container."
    exit 1
fi

echo "Optimizing Laravel..."
php artisan config:clear
php artisan cache:clear

echo "Starting Laravel development server..."
exec php artisan serve --host=0.0.0.0 --port=8000
