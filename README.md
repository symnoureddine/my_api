# Symfony 3.4 REST API  and JWT(Json Web Token)

## Install

    git clone https://github.com/symnoureddine/my_api.git
    cd my_api
    composer install

## Generate the SSH keys

	$ mkdir var/jwt 
	$ openssl genrsa -out var/jwt/private.pem -aes256 4096 
	$ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem

## Create database

    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force

## Load fixtures

 php bin/console  doctrine:fixtures:load

## Start local server

 php bin/console server:run


 # Launch tests

./vendor/bin/simple-phpunit
