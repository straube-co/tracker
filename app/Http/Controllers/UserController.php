<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        if (Auth::user()->can('admin')) {
            $users = User::get();
        } else {
            $users = User::where('id', Auth::id())->get();
        }

        $data = [
            'users' => $users,
        ];

        return view('user.index', $data);
    }

    public function create()
    {
        $this->authorize('admin');

        return view('user.create');
    }

    public function store(Request $request)
    {
        $this->authorize('report');

        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
        ]);

        if ($request->access) {
            $access = array_sum($request->access);
        } else {
            $access = User::DEFAULT_PERMISSION;
        }

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'access' => $access,
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        if (!Auth::user()->can('report') && Auth::id() !== $user->id) {
            abort(403);
        }

        $data = [
            'user' => $user,
        ];

        return view('user.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->can('report') && Auth::id() !== $user->id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => [
                'required',
                'email', Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|confirmed|min:5',
        ]);

        if ($validatedData['password']) {
            $user->update([
                'password' => Hash::make($validatedData['password']),
            ]);
        }

        if ($request->access) {
            $access = array_sum($request->access);
        } else {
            $access = User::DEFAULT_PERMISSION;
        }

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'access' => $access,
        ]);

        $user->save();

        return redirect()->route('user.index');
    }
}
