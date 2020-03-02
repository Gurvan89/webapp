#!/bin/bash

PHP_VERSION=php7.4

sudo apt-get update
sudo apt -y install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update

sudo apt -y install ${PHP_VERSION} ${PHP_VERSION}-xml ${PHP_VERSION}-mbstring
