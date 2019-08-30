FROM php:7.1-apache

LABEL description="debian 9, apache 2.4, php 7.1 | DOCUMENT_ROOT=/var/www/html/public/"


# Surpresses debconf complaints of trying to install apt packages interactively
# https://github.com/moby/moby/issues/4032#issuecomment-192327844
 
ARG DEBIAN_FRONTEND=noninteractive

# Update
RUN apt-get -y update --fix-missing ; \
    apt-get upgrade -y ; \
    apt-get --no-install-recommends install -y apt-utils ; \
    rm -rf /var/lib/apt/lists/*


# Install useful tools and install important libaries
RUN apt-get -y update ; \
    apt-get -y --no-install-recommends install nano wget dialog libsqlite3-dev libsqlite3-0 ; \
    apt-get -y --no-install-recommends install mysql-client zlib1g-dev libzip-dev libicu-dev ; \
    apt-get -y --no-install-recommends install --fix-missing apt-utils build-essential git curl ; \ 
    apt-get -y --no-install-recommends install --fix-missing libcurl3 libcurl3-dev zip openssl ; \
    rm -rf /var/lib/apt/lists/* ; \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Other PHP7 Extensions

RUN docker-php-ext-install pdo_mysql ; \
    docker-php-ext-install pdo_sqlite ; \
    docker-php-ext-install mysqli ; \
    docker-php-ext-install curl ; \
    docker-php-ext-install tokenizer ; \
    docker-php-ext-install json ; \
    docker-php-ext-install zip ; \
    docker-php-ext-install -j$(nproc) intl ; \
    docker-php-ext-install mbstring ; \
    docker-php-ext-install gettext

# Install Freetype 
RUN apt-get -y update ; \
    apt-get --no-install-recommends install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev ; \
    rm -rf /var/lib/apt/lists/* ; \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ ; \
    docker-php-ext-install -j$(nproc) gd

# Enable apache modules
RUN a2enmod rewrite headers

# Cleanup
RUN rm -rf /usr/src/*

ENV APACHE_LOCK_DIR="/var/lock"
ENV APACHE_PID_FILE="/var/run/apache2.pid"
ENV APACHE_RUN_USER="www-data"
ENV APACHE_RUN_GROUP="www-data"
ENV APACHE_LOG_DIR="/var/log/apache2"

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public/
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

VOLUME /var/www/html/

ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
