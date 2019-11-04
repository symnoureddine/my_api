# Symfony 3.4 REST API

## Install

    git clone https://github.com/symnoureddine/my_api.git
    cd my_api
    composer install

## Create database

    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force

## Load fixtures

 php bin/console  doctrine:fixtures:load

## Start local server

 php bin/console server:run


 # Launch tests
./vendor/bin/phpunit
