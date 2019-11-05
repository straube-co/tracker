<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;

/**
 * User controller.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
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
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'access' => 'required',
            'password' => 'required|confirmed|min:5',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'access' => $validatedData['access'],
            'password' => Hash::make($validatedData['password']),
        ]);

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
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => [
                'required',
                'email', Rule::unique('users', 'email')->ignore($user->id),
            ],
            'access' => 'required',
            'password' => 'nullable|confirmed|min:5',
        ]);

        if ($validatedData['password']) {
            $user->update([
                'password' => Hash::make($validatedData['password']),
            ]);
        }

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'access' => $validatedData['access'],
        ]);

        $user->save();

        return redirect()->route('user.index');
    }
}
