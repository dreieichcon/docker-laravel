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

echo "Waiting for database to be available..."
max_attempts=30
attempt=0

until php artisan migrate:status > /dev/null 2>&1 || [ $attempt -eq $max_attempts ]; do
    echo "Database not ready, waiting... (attempt $((attempt+1))/$max_attempts)"
    sleep 2
    attempt=$((attempt+1))
done

if [ $attempt -eq $max_attempts ]; then
    echo "Warning: Database connection failed after $max_attempts attempts"
    echo "Continuing without running migrations..."
else
    echo "Database is ready!"

    echo "Running php artisan migrate:fresh --seed..."
    php artisan migrate:fresh --seed --force
fi

echo "Optimizing Laravel..."
php artisan config:clear
php artisan cache:clear

echo "Starting Laravel development server..."
exec php artisan serve --host=0.0.0.0 --port=8000