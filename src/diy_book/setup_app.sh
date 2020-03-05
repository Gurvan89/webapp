#!/bin/bash


# to install dependencies. Composer install will use composer.lock to download dependencies
composer install

#to create main database
php bin/console doctrine:database:create --if-not-exists

#to create test database
php bin/console doctrine:database:create --if-not-exists --env=test

#to create table with entities
php bin/console doctrine:schema:update --force

#to create table with entities for database test
php bin/console doctrine:schema:update --force --env=test

#to clear server cache
php bin/console cache:clear