<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Password;

/**
 * Users API controller.
 *
 * @version 2.0.0
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

    public function index(): Collection
    {
        return User::orderBy('name')->get();
    }

    public function store(UserRequest $request): User
    {
        $user = User::create($request->validated());

        // Send email to user create a new password
        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);

        return $user;
    }

    public function update(UserRequest $request, User $user): User
    {
        $user->update($request->validated());
        return $user;
    }
}
