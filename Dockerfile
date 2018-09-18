# Starting from base
FROM php:7.0-apache

# File Author / Maintainer
MAINTAINER Cavid Kerimov

RUN apt-get update

# Install mysql, pdo extenions
RUN docker-php-ext-install pdo_mysql
RUN apt-get install nano

# Enable apache mods.
#RUN a2enmod php7.0
RUN a2enmod rewrite

#RUN apt-get install -y software-properties-common && apt-get update
#RUN apt-get install -y - force-yes curl
# Manually set up the apache environment variables
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
# Expose apache.
EXPOSE 80
EXPOSE 8080
EXPOSE 443


# Update the default apache site with the config we created.
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite

RUN apt-get -y install git
RUN git clone https://github.com/cavid90/api.git /var/www/html
CMD echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN service apache2 restart

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]