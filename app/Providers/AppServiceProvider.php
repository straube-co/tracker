<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(\Asana\Client::class, function ($app) {
            return \Asana\Client::oauth(array(
                'client_id' => '1111563149030062',
                'client_secret' => 'f4d57c9680875e8c00516d261846c6b5',
                'redirect_uri' => 'https://737b3683.ngrok.io/auth/handle',
            ));
        });
    }
}
