# syntax=docker/dockerfile:1

FROM php:8.2-cli AS base

# System dependencies + PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl unzip zip \
        libpng-dev libonig-dev libxml2-dev libzip-dev libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# --- PHP dependencies (cached layer) ---------------------------------------
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# --- Node dependencies (cached layer) ------------------------------------
COPY package.json package-lock.json ./
RUN npm ci

# --- Application code -----------------------------------------------------
COPY . .

RUN composer dump-autoload --optimize --classmap-authoritative \
    && npm run build \
    && rm -rf node_modules \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Config/route/view caches are built at startup (after env vars exist),
# not here — see docker-entrypoint.sh.

ENV PORT=8000
EXPOSE 8000

ENTRYPOINT ["sh", "/var/www/html/docker-entrypoint.sh"]
