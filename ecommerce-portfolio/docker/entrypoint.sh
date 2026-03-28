#!/bin/sh
set -e

# ──────────────────────────────────────────────────────────────────
# Docker Entrypoint for Laravel (PostgreSQL)
# ──────────────────────────────────────────────────────────────────

# Run migrations
echo "→ Running migrations..."
php artisan migrate --force --no-interaction

# Cache config / routes / views in production
if [ "$APP_ENV" = "production" ]; then
    echo "→ Caching config, routes, and views..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

echo "→ Starting PHP-FPM..."
exec "$@"
