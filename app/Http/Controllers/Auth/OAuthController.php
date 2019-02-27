<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Asana\Client;
use App\User;
use Exception;

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
        $me = $this->client->users->me();
        $request->session()->put('auth.id', $me->id);
        $count = \App\User::where('id', $me->id)->count();

        if ($count === 0){
            User::create([
                'id' => $me->id,
                'name' => $me->name,
                'email' => $me->email,
            ]);
        }
        return redirect('/');
    }
}
