<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OutController extends Controller
{
    public function index(Request $request)
    {

        Auth::logout();

        return redirect('/');
    }
}
