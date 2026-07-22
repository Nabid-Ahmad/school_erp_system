#!/usr/bin/env bash
# exit on error
set -o errexit

echo "Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev

# echo "Installing Node dependencies..."
# npm install

# echo "Building assets..."
# npm run build

echo "Clearing and caching configuration..."
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

echo "Linking storage..."
php artisan storage:link --relative

echo "Seeding database..."
# Uncomment the line below if you want to seed the database on every deploy
# php artisan db:seed --force
