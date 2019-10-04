<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\User;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class UserController extends Controller
{
    public function index()
    {

        $users = User::get();

        $data = [
            'users' => $users,

        ];

        return view('user.index', $data);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

        $access = $request->get('access', []);

        User::where('id', '>', 0)->update([
            'access' => 0,
        ]);

        foreach ($access as $userId => $arr) {
            User::where('id', $userId)->update([
                'access' => array_sum($arr),
            ]);
        }

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {

        $data = [
            'user' => $user,
        ];

        return view('user.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        return redirect()->route('user.index');
    }
}
