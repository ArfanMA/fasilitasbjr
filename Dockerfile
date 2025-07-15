FROM ghcr.io/railwayapp/php

RUN install-php-extensions pdo_mysql

# Izin untuk folder yang dibutuhkan Laravel
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache
