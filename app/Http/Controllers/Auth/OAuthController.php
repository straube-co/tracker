<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Asana\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use Exception;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class OAuthController extends Controller
{

    /**
     * The Asana client instance.
     *
     * @var \Asana\Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function auth()
    {
        if ($this->client->dispatcher->authorized) {
            return redirect('/');
        }

        $state = null;
        $url = $this->client->dispatcher->authorizationUrl($state);
        request()->session()->flash('auth.state', $state);
        return redirect($url);
    }

    public function handle()
    {
        $request = request();
        $code = $request->code;
        if ($request->session()->get('auth.state') != $request->state) {
            throw new Exception('Invalid state');
        }

        $token = $this->client->dispatcher->fetchToken($code);
        $request->session()->put('auth.token', $token);
        $me_user = $this->client->users->me();

        $inWorkspaces = false;

        foreach ($me_user->workspaces as $workspace) {
            if ($workspace->gid === '870874468980849') {
                $inWorkspaces = true;
                break;
            }
        }
        if ($inWorkspaces == false) {
            abort(403, 'Acesso negado!');
        }

        $user = User::find($me_user->id);

        Auth::login($user);

        if (!$user) {
            User::create([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }
        return redirect('/');
    }
}
