#!/bin/bash
# One-Click Production Deployment Script for Linux / Ubuntu VPS

set -e

echo "🚀 Starting Crescent Model School ERP Production Deployment..."

# 1. Install Composer Dependencies (optimized)
composer install --no-dev --optimize-autoloader --no-interaction

# 2. Check and copy .env if missing
if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
    php artisan key:generate --force
fi

# 3. Create SQLite Database if missing
touch database/database.sqlite
chmod 664 database/database.sqlite

# 4. Run Migrations and Seeders
php artisan migrate --force --seed --no-interaction

# 5. Clear and Cache Configuration & Routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Set correct permissions
chmod -R 775 storage bootstrap/cache

echo "✅ Production Deployment Complete! Your ERP is ready to serve."
