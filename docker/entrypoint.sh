#!/bin/sh
set -e

cd /var/www/html

# Render injects PORT (default 10000)
export PORT="${PORT:-8080}"

# Generate nginx config from template
envsubst '${PORT}' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf

# Laravel production optimizations (skip if APP_KEY not set yet)
if [ -n "$APP_KEY" ] && [ "$APP_KEY" != "" ]; then
    php artisan config:cache --no-interaction 2>/dev/null || true
    php artisan route:cache --no-interaction 2>/dev/null || true
    php artisan view:cache --no-interaction 2>/dev/null || true

    # Run migrations on deploy (safe for Supabase)
    php artisan migrate --force --no-interaction 2>/dev/null || true
fi

exec "$@"
