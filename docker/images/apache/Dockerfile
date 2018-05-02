FROM php:7.2-apache

RUN apt-get update && \
    apt-get install -y zip \
                       vim \
                       mysql-client && \
    apt-get clean

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite && \
    a2enmod headers

ADD bootstrap.sh /root/bootstrap.sh
ENTRYPOINT [ "sh", "/root/bootstrap.sh" ]

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/flo-tournoi

CMD ["apache2-foreground"]
