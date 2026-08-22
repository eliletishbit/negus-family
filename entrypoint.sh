#!/bin/bash

echo "=== Starting entrypoint ==="

mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exécuter les migrations (avec les variables d'environnement Render)
php artisan migrate --force

# Si tu veux aussi lancer les seeders
php artisan db:seed --force

service nginx start
php-fpm -F