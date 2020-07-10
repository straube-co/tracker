#!/bin/sh
set -e

# Make project root the current dir
cd "$(dirname "$0")"

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    # Update codebase
    git fetch origin master
    git reset --hard origin/master

    # Install dependencies based on lock file
    composer install --no-interaction --prefer-dist --optimize-autoloader

    # Migrate database
    php artisan migrate --force

    # Update routes
    php artisan ziggy:generate resources/js/ziggy.js

    # Compile prod-ready assets
    npm ci
    npm run prod

    # Clear cache
    php artisan optimize

    # Reload PHP to update opcache
    echo "" | sudo -S service php7.4-fpm reload
# Exit maintenance mode
php artisan up

echo "Application deployed!"
