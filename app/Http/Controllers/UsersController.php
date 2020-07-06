<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $users = User::orderBy('name')->get();

        $data = [
            'users' => $users,
        ];
        return view('users.index', $data);
    }
}
