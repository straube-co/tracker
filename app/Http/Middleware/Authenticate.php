<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

/**
 * Authenticate middleware.
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
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
        $user = Auth::user();

        if ($user) {
            return $next($request);
        }

        return $this->logout($request);
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

        abort(403);
    }
}
