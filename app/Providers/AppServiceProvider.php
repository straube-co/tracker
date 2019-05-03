<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Asana\Client::class, function () {
            return \Asana\Client::oauth(array(
                'client_id' => env('ASANA_ID'),
                'client_secret' => env('ASANA_SECRET'),
                'redirect_uri' => env('ASANA_URL'),
            ));
        });
    }
}
