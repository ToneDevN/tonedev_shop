#!/bin/sh
set -e

# ──────────────────────────────────────────────────────────────────
# Docker Entrypoint for Laravel (PostgreSQL)
# Runs as root → fixes permissions → drops to www via su-exec
# ──────────────────────────────────────────────────────────────────

# Fix storage permissions (volume mount may override Dockerfile chown)
echo "→ Fixing storage permissions..."
chown -R www:www /var/www/storage /var/www/bootstrap/cache
chmod -R 775     /var/www/storage /var/www/bootstrap/cache

# Run migrations (as www)
echo "→ Running migrations..."
su-exec www php artisan migrate --force --no-interaction

# Cache config / routes / views in production
if [ "$APP_ENV" = "production" ]; then
    echo "→ Caching config, routes, and views..."
    su-exec www php artisan config:cache
    su-exec www php artisan route:cache
    su-exec www php artisan view:cache
fi

# Create storage symlink
su-exec www php artisan storage:link --force 2>/dev/null || true

echo "→ Starting PHP-FPM as www..."
exec su-exec www "$@"
