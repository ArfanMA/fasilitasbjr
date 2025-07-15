FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip curl git \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /var/www

# Set working directory
WORKDIR /var/www

# Set permissions
RUN chmod -R 755 /var/www

# Copy nginx config
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Start php-fpm and nginx
CMD service nginx start && php-fpm
