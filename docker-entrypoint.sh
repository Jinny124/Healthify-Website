#!/bin/sh
set -e

# Port is provided by the host (Railway, Render, Fly, ...); default for local runs.
PORT="${PORT:-8000}"

echo "==> Preparing Laravel"

# Generate an app key only if one was not supplied via the environment.
if [ -z "${APP_KEY}" ]; then
    php artisan key:generate --force
fi

# Link storage for public file access (ignore if it already exists).
php artisan storage:link || true

# Run database migrations. Requires DB_* env vars to point at a real database.
php artisan migrate --force

# Cache configuration now that all env vars are available.
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Starting server on 0.0.0.0:${PORT}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
