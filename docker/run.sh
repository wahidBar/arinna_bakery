#!/bin/sh

# If Render passes a PORT env var, update Nginx config to listen on it
if [ -n "$PORT" ]; then
    sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/http.d/default.conf
fi

# Clear and cache routes, views, config
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations automatically
# Remove this if you don't want migrations to run automatically on every deploy
php artisan migrate --force

# Start Supervisor
exec /usr/bin/supervisord -c /etc/supervisord.conf
