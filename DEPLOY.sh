cp .env .env

php artisan key:generate

php artisan migrate:fresh --seed
