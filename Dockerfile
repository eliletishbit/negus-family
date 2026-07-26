# 1. Utiliser une image PHP-FPM avec Node.js
FROM php:8.2-fpm

# 2. Installation des dépendances (Nginx, Node.js, extensions PHP)
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 3. Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Configuration Nginx (optimisée pour Laravel)
RUN echo 'server { \
    listen 8080; \
    server_name _; \
    root /var/www/html/public; \
    index index.php index.html; \
    charset utf-8; \
    add_header X-Frame-Options "SAMEORIGIN" always; \
    add_header X-Content-Type-Options "nosniff" always; \
    add_header X-XSS-Protection "1; mode=block" always; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        include fastcgi_params; \
    } \
    location ~* \.(js|css|woff2|woff|ttf|png|jpg|jpeg|gif|ico|svg)$ { \
        add_header Access-Control-Allow-Origin *; \
        expires 1y; \
        add_header Cache-Control "public, immutable"; \
        log_not_found off; \
    } \
    location ~ /\.(?!well-known).* { \
        deny all; \
    } \
}' > /etc/nginx/sites-available/default

# 5. Définir le répertoire de travail
WORKDIR /var/www/html

# 6. Copier les fichiers de dépendances
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# 7. Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 8. Installer les dépendances Node.js
RUN npm install

# 9. Copier tout le code source
COPY . .

# 10. Exécuter les scripts Composer
RUN composer run-script post-autoload-dump

# 11. Builder les assets Vite avec l'URL correcte
ENV APP_URL=https://negus-family-production.up.railway.app
RUN npx vite build

# 12. Optimiser Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# 13. Permissions pour Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 14. Exposer le port
EXPOSE 8080

# 15. Script de démarrage
CMD php artisan storage:link && service nginx start && php-fpm -F