<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('report', function (?User $user) {
            $user_ = request()->session()->get('auth.id');

            $userId = User::find($user_);

            return in_array(2, $userId->access());
        });

        Gate::define('settings', function (?User $user) {
            $user_ = request()->session()->get('auth.id');

            $userId = User::find($user_);

            return in_array(1, $userId->access());
        });
    }
}
