FROM php:7.4-apache
ENV COMPOSER_ALLOW_SUPERUSER=1
EXPOSE 80
RUN mkdir -p /home/webApp/.
WORKDIR /home/webApp/.
#VOLUME ["../../src/diy_book", "/home/webApp"]


RUN apt-get update -qy && \
    apt-get install -y \
    git \
    libicu-dev \
    unzip \
    zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# PHP Extensions
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql

ADD config/apache/* /etc/apache2/sites-available/000-default.conf
# CMD ["ls -l /home/webApp"]
# FROM ubuntu:18.04
# RUN apt-get update

# # create directory for web app
# 

# #install php 7.4
# RUN apt-get -y install software-properties-common
# RUN add-apt-repository ppa:ondrej/php
# RUN apt-get -y update
# RUN apt-get -y install php7.4 php7.4-xml php7.4-mbstring

# # Install apache 2 and enable php module
# RUN apt-get install -y apache2
# #COPY config/apache/* /etc/apache2/sites-available/.
# #RUN a2enmod php7.4

# #CMD [""]

