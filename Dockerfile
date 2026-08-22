FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx libpng-dev libzip-dev zip unzip git nodejs npm \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Copier la nouvelle configuration nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Configurer PHP pour l'upload
RUN echo "upload_max_filesize = 50M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

COPY composer.json composer.lock ./

# Configurer Composer pour éviter les timeout GitHub
RUN composer config -g github-protocols https
RUN composer config -g repo.packagist composer https://packagist.org

RUN composer install --optimize-autoloader --no-scripts

COPY package.json package-lock.json ./
RUN npm install

COPY . .

RUN npm run build

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

USER root
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]