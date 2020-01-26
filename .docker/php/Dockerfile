FROM php:7.2-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libzmq3-dev wget git \
    && pecl install zmq-beta \
    && docker-php-ext-install zip \
    && docker-php-ext-enable zmq

# PHP Extensions
# RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN \
  curl 'http://pecl.php.net/get/redis-5.1.1.tgz' -o /tmp/redis-5.1.1.tgz  \
  && cd /tmp \
  && pecl install redis-3.1.5.tgz \
  && rm -rf redis-5.1.1.tgz \
  && docker-php-ext-enable redis

WORKDIR /var/vhosts/simplechat
