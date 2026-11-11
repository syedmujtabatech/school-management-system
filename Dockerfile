# Production Dockerfile for Crescent Model School ERP (Laravel 12)
FROM php:8.2-cli-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite \
    sqlite-dev \
    oniguruma-dev

RUN docker-php-ext-install pdo pdo_sqlite mbstring bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions for Laravel storage and bootstrap cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Ensure SQLite database exists
RUN touch /var/www/database/database.sqlite && \
    chmod 664 /var/www/database/database.sqlite

# Expose port (Render/Railway/Fly.io inject PORT environment variable)
ENV PORT=8000
EXPOSE 8000

# Copy and make entrypoint executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
