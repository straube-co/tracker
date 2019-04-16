<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Authenticate middleware.
 */
class Authenticate
{

    /**
     * Handle an incoming request.
     *
     * If the current session does not have a valid ID, the user will be
     * redirected to the authorization flow.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->session()->get('auth.id');

        if ($this->isIdValid($id)) {
            return $next($request);
        }

        return $this->logout($request);
    }

    /**
     * Check whether the given ID is valid.
     *
     * @param  string|null $id
     * @return bool
     */
    private function isIdValid(?string $id): bool
    {
        if (empty($id)) {
            return false;
        }
        //Verificar se o usuário existe no banco
        $user = User::where('user_id', $id)->count();
        //return boolean
        return $user === 1;
    }

    /**
     * Log out the current user and redirect it to login.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function logout(Request $request): RedirectResponse
    {
        $request->session()->flush();

        return redirect()->route('auth.auth');
    }
}
