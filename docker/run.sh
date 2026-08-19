#!/bin/sh

set -eu

port="${PORT:-8080}"

case "$port" in
    ''|*[!0-9]*)
        echo "PORT must be a numeric TCP port, received: $port" >&2
        exit 1
        ;;
esac

echo "=========================================="
echo "Railway PORT: ${port}"
echo "=========================================="

sed -i "s/listen 8080;/listen ${port};/g" \
    /etc/nginx/http.d/default.conf

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    php artisan migrate --force
fi

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=========================================="
echo "Starting Supervisor"
echo "Nginx will listen on port: ${port}"
echo "=========================================="

exec /usr/bin/supervisord -c /etc/supervisord.conf