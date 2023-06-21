echo "Este programa requiere tener instalado de antemano httpd, php, composer, mysql/mariadb y npm"

composer install

npm install

npm audit fix

cp .env.example .env

php artisan key:generate

nano .env

php artisan migrate:fresh --seed

echo "Todavia tienes que en esta misma ruta en otra consola ejecutar 'npm run dev' antes de utilizar la aplicacion"

php artisan serve
