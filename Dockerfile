# 1. Base image
FROM php:8.1-fpm

# 2. Sistem paketleri
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    libonig-dev \
    libpng-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# 3. Composer kur
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Proje dosyalarını kopyala
WORKDIR /var/www
COPY . .

# 5. Laravel için izinler
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# 6. Composer bağımlılıkları yükle
RUN composer install --no-interaction

# 7. Environment
ENV APP_ENV=production
ENV APP_KEY=base64:c4HwcqQdI7n6dem0XGJZjxLYeYjTt5rD5aftSDYmPto=
ENV APP_DEBUG=false
ENV APP_URL=https://cdrive-pro.up.railway.app/

# 8. Storage link
RUN php artisan storage:link

# 9. Port
EXPOSE 8000

# 10. Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
