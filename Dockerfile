FROM webdevops/php-nginx:8.2

RUN install-php-extensions pdo_mysql
