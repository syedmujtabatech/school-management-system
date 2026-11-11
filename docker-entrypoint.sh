#!/bin/sh
set -e

# Copy environment if not present
if [ ! -f /var/www/.env ]; then
    cp /var/www/.env.example /var/www/.env
fi

# Generate key if empty
php artisan key:generate --force --no-interaction

# Prepare database
touch /var/www/database/database.sqlite
chmod 664 /var/www/database/database.sqlite
php artisan migrate --force --seed --no-interaction

# Optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=========================================================="
echo "🎓 Crescent Model School ERP is starting on port ${PORT:-8000}"
echo "=========================================================="

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
