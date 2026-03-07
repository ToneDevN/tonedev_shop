#!/bin/sh
set -e

# ──────────────────────────────────────────────────────────────────
# Docker Entrypoint for Laravel 12
# ──────────────────────────────────────────────────────────────────

# สร้าง SQLite database ถ้ายังไม่มี
DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
if [ ! -f "$DB_FILE" ]; then
    echo "→ Creating SQLite database at $DB_FILE"
    mkdir -p "$(dirname "$DB_FILE")"
    touch "$DB_FILE"
    chown www-data:www-data "$DB_FILE"
fi

# รัน migrations อัตโนมัติตอน boot
echo "→ Running migrations..."
php artisan migrate --force --no-interaction

# Cache configs สำหรับ production
if [ "$APP_ENV" = "production" ]; then
    echo "→ Caching config / routes / views..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# สร้าง storage symlink
php artisan storage:link --force 2>/dev/null || true

echo "→ Starting application..."
exec "$@"
