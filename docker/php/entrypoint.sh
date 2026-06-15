#!/usr/bin/env bash
set -e

cd /var/www/html

if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

mkdir -p vendor storage bootstrap/cache
chown -R laravel:laravel vendor storage bootstrap/cache

if [ ! -f vendor/autoload.php ]; then
    runuser -u laravel -- composer install
fi

if [ -f artisan ]; then
    runuser -u laravel -- php artisan package:discover --ansi || true

    if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
        runuser -u laravel -- php artisan key:generate --ansi
    fi
fi

exec runuser -u laravel -- "$@"
