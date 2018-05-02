FROM php:7.2

RUN apt-get update && \
    apt-get install -y zlib1g-dev && \
    apt-get clean

RUN docker-php-ext-install pdo_mysql \
                           zip

RUN curl -fsSL https://getcomposer.org/installer | php \
&& mv composer.phar /usr/local/bin/composer
