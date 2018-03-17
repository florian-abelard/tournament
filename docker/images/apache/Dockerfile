FROM php:7.2-apache

RUN apt-get update \
&& apt-get install -y zip \
&& apt-get clean

RUN a2enmod rewrite

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/floTournoi

CMD ["apache2-foreground"]
