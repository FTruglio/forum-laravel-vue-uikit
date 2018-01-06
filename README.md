# Laravel Forum

This is an open source forum built with laravel 5.5. & vue 2.0

## Installation
------

### Step 1.
To run this project, you must have PHP 7 Installed as a prerequisite.

Begin by cloning this repository to your machine, and installing all composer dependencies.

https://github.com/FTruglio/tdd-forum.git
cd tdd-forum && composer install
php artisan key:generate
mv .env.example .env

### Step 2.

- Next, create a new database and reference its name and username/password within the project's .env file. see example below.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forum
DB_USERNAME=root
DB_PASSWORD=
```

- Migrate the database

php artisan migrate

### Step 3.

- reCaptcha account is required from google. Link here:

- Fill in the credentials from reCaptcha in your .env file:

```
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECERET_KEY=
```

### Step 4.

php artisan cache:clear







