# Gunakan image resmi PHP dengan ekstensi yang dibutuhkan
FROM php:8.2-apache

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy seluruh isi project Laravel ke container
COPY . .

# Install dependency Laravel
RUN composer install --optimize-autoloader --no-dev

# Set permission Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Copy default Apache vhost config
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Aktifkan mod_rewrite untuk Laravel
RUN a2enmod rewrite

# Expose port Apache
EXPOSE 80

# Jalankan Apache saat container dimulai
CMD ["apache2-foreground"]
