# Learning Management System Backend
This is the repository of the backend used by the Learning management system.
Corresponding frontend can be found in this [repo](https://github.com/sunhesh12/GroupProjectFrontend).

## How to start development

### Install Laravel

  You can find how to install using this [link](https://laravel.com/docs/11.x/#installing-php)

### Installing dependencies

Go inside the folder containing the repository

```
cd lms-backend
```

Install the dependencies using composer
```
composer install
```
### Add the environment variables (.env)

Get the .env file from this [link](https://drive.google.com/file/d/1X9JV6HfIh2zB7vqHNunKx_R48Qquz6fx/view?usp=sharing)

Copy it into the folder containing the repository.

change the followig variables as given

```
DB_CONNECTION=mysql
DB_DATABASE=lms_backend
DB_USERNAME=root
DB_PASSWORD=root
```
If this doesen't work check the username and password of your mysql database and set DB_USERNAME and DB_PASSWORD accordingly

### Generate the App Key (APP_KEY environment variable)

Execute the following command

```
php artisan generate:key
```
### Run all the database migrations

Need to create the table structures in the mysql database 'lms_backend'

```
php artisan migrate
```
### Start the development server

Need to start in order to check and run api routes

```
php artisan serve
```

## Important considerations

- NEVER change database schema with mysql. Only change it through laravel database migrations. Refer this [link](https://laravel.com/docs/11.x/migrations#generating-migrations)

## Backend API structure (Enpoints)

### Users

