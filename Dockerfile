# Utiliser l'image PHP 8.2 avec FPM
FROM php:8.2-fpm

# Installer Nginx, Node.js et les extensions PHP
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

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurer Nginx
RUN echo 'server { \
    listen 8080; \
    server_name _; \
    root /var/www/html/public; \
    index index.php index.html; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        include fastcgi_params; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
    } \
    location ~* \.(js|css|woff2|woff|ttf|png|jpg|jpeg|gif|ico|svg)$ { \
        add_header Access-Control-Allow-Origin *; \
        expires max; \
        log_not_found off; \
    } \
}' > /etc/nginx/sites-available/default

WORKDIR /var/www/html

# Copier les dépendances
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN npm install

# Copier le code source
COPY . .

# Builder les assets
RUN APP_URL=https://negus-family-production.up.railway.app ./node_modules/.bin/vite build

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 8080
EXPOSE 8080

# Démarrer Nginx et PHP
CMD php artisan storage:link && service nginx start && php-fpm -F