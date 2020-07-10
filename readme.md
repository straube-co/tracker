# Tracker

Time tracker app used internally at [Straube](https://straube.co/). It's built with
PHP using [Laravel](https://laravel.com/) framework.

## Installation

Installing all dependencies (back and front-end) requires
[Composer](https://getcomposer.org/) and NPM — which can be installed with
[Node.js](https://nodejs.org/). In case those tools are already available, run
the following commands to install the deps:

```
$ composer install
$ npm install
```

Create a new `.env` file based on the example provided with the project:

```
$ cp .env.example .env
```

Update the newly created `.env` file with the relevant settings, e.g. database
connection.

Then, run the migrations:

```
$ php artisan migrate
```

Finally, create a user to access the application:

```
$ php artisan tinker

>>> App\User::create([ 'email' => 'j.doe@domain.com', 'name' => 'John Doe', 'password' => Hash::make('secret') ]);
```

The values above are just an example. Feel free to replace them with your own
name, email, and secure password.

## Running

The easiest way to run this project is using
[Valet](https://laravel.com/docs/valet/). It's also possible to run it on PHP
built-in web server, through the respective Artisan command:

```
$ php artisan serve
```

### Named routes

This project uses [Ziggy](https://github.com/tightenco/ziggy) to access Laravel
named routes in Javascript. The current configuration makes only API routes to
be exported. When new API routes are added to the application, the routes file
must be re-generated:

```
$ php artisan ziggy:generate resources/js/ziggy.js
```

Then, build the assets:

```
$ npm run dev
```

## Building

Set the correct URL when generating the routes for production:

```
$ APP_URL=https://tracker.straube.co php artisan ziggy:generate resources/js/ziggy.js
```

Then build the assets for that env:

```
$ npm run prod
```

When using the `deploy.sh` script on the server, there is no need to manually
run the steps above in the local/dev env before deploying changes involving
Javascript assets.
