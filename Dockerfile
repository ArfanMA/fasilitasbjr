FROM webdevops/php-nginx:8.2

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /app

# Salin semua file project ke dalam container
COPY . .

# Set permission biar folder bisa diakses server
RUN chmod -R 755 /app

# Jalankan Laravel dari folder public/
CMD ["supervisord"]
