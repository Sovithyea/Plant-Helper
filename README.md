###1 Installation
- copy .env.example and rename .env
- configure Database connection
- run the following command:
  - composer install
  - php artisan migrate:fresh --seed
  - php artisan passport:install
  - php artisan key:generate
