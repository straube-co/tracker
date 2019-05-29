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
}
