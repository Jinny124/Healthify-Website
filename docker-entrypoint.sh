#!/bin/sh
set -e

# Port is provided by the host (Railway, Render, Fly, ...); default for local runs.
PORT="${PORT:-8000}"

echo "==> Preparing Laravel"

# APP_KEY must be supplied as an environment variable and stay stable across
# deploys (a changing key invalidates all sessions and encrypted data).
if [ -z "${APP_KEY}" ]; then
    echo "ERROR: APP_KEY is not set." >&2
    echo "Generate one locally with:  php artisan key:generate --show" >&2
    echo "then add it to the host's environment variables." >&2
    exit 1
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
