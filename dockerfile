FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY ./login_acesso /var/www/html

EXPOSE 80
