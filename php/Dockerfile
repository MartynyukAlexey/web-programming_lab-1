FROM php:8.1-fpm

RUN apt-get update && \
    docker-php-ext-install pdo pdo_mysql
 
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install gd

ENTRYPOINT ["php-fpm"]