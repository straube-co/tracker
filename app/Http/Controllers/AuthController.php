<?php

namespace App\Http\Controllers;

use App\User;
use Asana\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Authentication controller.
 *
 * This controller handles the authentication flow using the Asana client.
 *
 * @author Lucas Cardoso <lucas@straube.co>
 * @author Gustavo Straube <gustavo@straube.co>
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class AuthController extends Controller
{
    /**
     * The Asana workspace ID.
     *
     * @var string
     */
    const ASANA_WORKSPACE = '870874468980849';

    /**
     * The Asana client instance.
     *
     * @var \Asana\Client
     */
    private $client;

    /**
     * Create a new instance.
     *
     * @param \Asana\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Direct the user to log into Asana.
     *
     * If the user is already authenticated. Redirect them to the time tracking
     * page.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('time.index');
        }

        if ($this->client->dispatcher->authorized) {
            $this->authUser();
            return redirect()->route('time.index');
        }

        $state = null; // Will be passed by ref.
        $url = $this->client->dispatcher->authorizationUrl($state);
        $request->session()->flash('auth.state', $state);
        return redirect($url);
    }

    /**
     * Handle the OAuth response from Asana.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function handle(Request $request): RedirectResponse
    {
        $session = $request->session();

        if ($session->get('auth.state') !== (int) $request->state) {
            abort(403, 'Access denied. Invalid state.');
        }

        $token = $this->client->dispatcher->fetchToken($request->code);
        $session->put('auth.token', $token);

        $this->authUser();
        return redirect()->route('time.index');
    }

    /**
     * Log the current user out.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Authenticate the Asana user into the app.
     *
     * @return void
     */
    private function authUser(): void
    {
        $user = $this->client->users->me();
        if (!$this->inWorkspace($user)) {
            abort(403, 'Access denied. You are not in a valid Asana workspace.');
        }

        Auth::login(User::firstOrCreate([
            'id' => $user->id,
        ], [
            'name' => $user->name,
            'email' => $user->email,
        ]));
    }

    /**
     * Check whether the give user is in the Asana workspace.
     *
     * @param  object $user
     * @return bool
     */
    private function inWorkspace($user): bool // TODO: Use the right type for $user
    {
        foreach ($user->workspaces as $workspace) {
            if ($workspace->gid === self::ASANA_WORKSPACE) {
                return true;
            }
        }
        return false;
    }
}
