#!/bin/sh
set -e

# ──────────────────────────────────────────────────────────────────
# Docker Entrypoint for Laravel (PostgreSQL)
# ──────────────────────────────────────────────────────────────────

# Fix permissions on everything because Docker volumes mount as root initially
echo "→ Setting storage permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true

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
