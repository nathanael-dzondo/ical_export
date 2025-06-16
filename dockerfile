FROM php:7.4.33-apache
EXPOSE 80
RUN docker-php-ext-install pdo pdo_mysql
COPY . /var/www/html/
