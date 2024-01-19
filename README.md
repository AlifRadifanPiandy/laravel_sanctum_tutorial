# Laravel Sanctum Tutorial
This is the official repository for my Laravel Sanctum Tutorial. <br>
•	Author: Alif Radifan Piandy <br>

### Utilities
The following additional tools will be used during this tutorial

- [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum) for an authentication system
- [Postman](https://www.postman.com/) for our Laravel API

## Usage <br>
Setup the repository <br>
```
git clone git@github.com:AlifRadifanPiandy/laravel_sanctum_tutorial.git
cd laravel-sanctum-tutorial
composer install
cp .env.example .env 
php artisan key:generate
php artisan cache:clear && php artisan config:clear 
php artisan serve 
```

## Database Setup <br>
```
mysql;
create database laravel_sanctum_tutorial;
exit;
```


### Setup your database credentials in the ```.env``` file <br>
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_sanctum_tutorial
DB_USERNAME={USERNAME}
DB_PASSWORD={PASSWORD}
```

### Sanctum
Before you can use Laravel Sanctum, you obviously need to make sure that you install it through Composer. Besides that, you should upblish the Sanctum configuration file as well.
```
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### Migrate tables
```
php artisan migrate
```

# Credits due where credits due…
Thanks to [Laravel](https://laravel.com/) for giving me the opportunity to make this tutorial on [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum). 
# laravel_sanctum_tutorial
