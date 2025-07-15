FROM webdevops/php-nginx:8.2

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . /var/www

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set permissions
RUN chmod -R 755 /var/www

# Expose port 80
EXPOSE 80
COPY nginx/default.conf /opt/docker/etc/nginx/vhost.common.d/default.conf

