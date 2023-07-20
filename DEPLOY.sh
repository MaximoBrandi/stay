#!/bin/bash

echo "This application requires httpd, php, composer, mysql/mariadb and npm"


if ! command -v php &> /dev/null; then
    echo "php no okay"
    set -e
    ls /nonexistent_directory
else
    echo "php okay"
fi

if ! command -v composer &> /dev/null; then
    echo "composer no okay"
    set -e
    ls /nonexistent_directory
else
    echo "composer okay"
fi

if ! command -v npm &> /dev/null; then
    echo "npm no okay"
    set -e
    ls /nonexistent_directory
else
    echo "npm okay"
fi

if ! command -v nano &> /dev/null; then
    echo "nano no okay"
    set -e
    ls /nonexistent_directory
else
    echo "nano okay"
fi

# Verificar que los servicios están en ejecución
if ! systemctl is-active --quiet httpd; then
    echo "httpd no okay"
    set -e
    ls /nonexistent_directory
else
    echo "httpd okay"
fi

if ! systemctl is-active --quiet mariadb; then
    echo "mariadb no okay"
    set -e
    ls /nonexistent_directory
else
    echo "mariadb okay"
fi

# Continuar con el resto del código
echo "Everything is fine!"

composer install

npm install

npm audit fix

cp .env.example .env

cp examples/* storage/app/public/

php artisan key:generate

echo "Select the correct timezone, visit for more info https://www.php.net/manual/en/timezones.php"

nano .env

php artisan migrate:fresh --seeder=VirginStartupSeed

php artisan serve
