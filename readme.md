# Tracker

This is the time tracker app used internally by Straube. It's built with PHP
using Laravel framework.

## Installation

To install all dependencies (back and front-end) run the following commands:

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

The easiest way to run this project is using Valet. It's also possible to run it
on PHP built-in web server, through an Artisan command:

```
$ php artisan serve
```

### Named routes

This project uses Ziggy to access Laravel named routes on Javascript. The
current configuration makes only API routes to be exported. When new API routes
are added to the application, the routes file must be re-generated:

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

The steps above must be executed when merging code into `master` branch.
