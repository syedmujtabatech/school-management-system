@echo off
echo ==============================================================
echo 🚀 Crescent Model School ERP - Windows Production Setup
echo ==============================================================

if not exist .env (
    copy .env.example .env
    php artisan key:generate --force
)

echo [1/4] Installing Composer dependencies...
call composer install --no-dev --optimize-autoloader --no-interaction

echo [2/4] Migrating & Seeding Database...
call php artisan migrate --force --seed --no-interaction

echo [3/4] Caching Configuration, Routes & Views...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

echo [4/4] Starting Server...
echo ==============================================================
echo ✅ Ready! Starting at http://localhost:8000
echo ==============================================================
php artisan serve --port=8000
