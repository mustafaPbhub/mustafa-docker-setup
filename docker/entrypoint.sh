#!/bin/sh
set -e

echo "🚀 Starting Laravel container..."

# Wait for MySQL if DB_HOST is defined
if [ -n "$DB_HOST" ]; then
  echo "Waiting for database connection at $DB_HOST..."
  until nc -z "$DB_HOST" "${DB_PORT:-3306}"; do
    sleep 2
  done
  echo "Database is ready!"
fi

# Run Laravel setup commands safely
echo " Running Laravel setup..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan package:discover --ansi || true
php artisan config:cache || true
php artisan route:cache || true

echo " Laravel setup complete. Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
