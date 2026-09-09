# syntax=docker/dockerfile:1

FROM php:8.2-cli AS base

# System dependencies + PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl unzip zip ca-certificates \
        libpng-dev libonig-dev libxml2-dev libzip-dev libsqlite3-dev \
        nodejs npm \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# --- PHP dependencies ---------------------------------------------------
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# --- Node dependencies -------------------------------------------------
COPY package.json package-lock.json ./
RUN npm ci

# --- Application code -------------------------------------------------
COPY . .

RUN composer dump-autoload --optimize --classmap-authoritative --no-scripts \
    && npm run build \
    && rm -rf node_modules \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Config/route/view caches are primed at startup (after env vars exist),
# together with database migrations — see docker-entrypoint.sh.

ENV PORT=8000
EXPOSE 8000

ENTRYPOINT ["sh", "/var/www/html/docker-entrypoint.sh"]
