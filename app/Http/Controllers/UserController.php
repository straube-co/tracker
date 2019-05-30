<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

use App\User;

class UserController extends Controller
{
    public function index() {

        $users = Cache::remember('users', 1, function () {
            return User::get();
        });

        $data = [
            'users' => $users,
        ];

        return view('user.index', $data);
    }

    // public function boot()
    // {
    //     $this->registerPolicies();
    //
    //     Gate::define('access-page', 'App\Policies\PostPolicy@access');
    //
    //     if (Gate::forUser($user)->denies('update-post', $post)) {
    //         // The user can't update the post...
    //     }
    // }
}
