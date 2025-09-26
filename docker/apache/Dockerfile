FROM php:8.2-apache

RUN apt-get update && apt-get install -y curl && apt-get clean
RUN apt-get install -y procps
RUN a2enmod proxy proxy_http rewrite

COPY docker/apache/laravel-proxy.conf /etc/apache2/sites-available/laravel-proxy.conf

RUN a2ensite laravel-proxy.conf && a2dissite 000-default.conf

WORKDIR /var/www/html