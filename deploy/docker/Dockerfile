FROM php:7.4-apache
ENV COMPOSER_ALLOW_SUPERUSER=1
EXPOSE 80
RUN mkdir -p /home/webApp/.
WORKDIR /home/webApp/.

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

