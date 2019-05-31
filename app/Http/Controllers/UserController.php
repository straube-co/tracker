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

        $access = $request->get('access', []);

        User::update([
            'access' => 0,
        ]);

        foreach ($access as $userId => $arr){
            User::where('id', $userId)->update([
                'access' => array_sum($arr),
            ]);
        }

        return redirect()->route('user.index');
    }
}
