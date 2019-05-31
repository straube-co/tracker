<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
    public function store(Request $request) {

        $access = $request->get('access');


        dump($access);



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
