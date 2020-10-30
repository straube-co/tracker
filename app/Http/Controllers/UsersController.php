<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;

/**
 * Users controller.
 *
 * @version 2.0.0
 * @author  Lucas Cardoso <lucas@straube.co>
 * @author  Gustavo Straube <gustavo@straube.co>
 */
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
