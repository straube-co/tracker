<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Password;

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

    public function store(UserRequest $request): User
    {
        $user = User::create($request->validated());

        // Send email to user create a new password
        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);

        return $user;
    }
}
