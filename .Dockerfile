# Starting from base
FROM php:7.0-apache

# File Author / Maintainer
MAINTAINER Cavid Kerimov

# Install mysql, pdo extenions
RUN docker-php-ext-install mysql mysqli pdo pdo_mysql

# Install mbstring
RUN docker-php-ext-install mbstring

EXPOSE 80
CMD apachectl -D FOREGROUND