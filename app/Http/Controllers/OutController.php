<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class OutController extends Controller
{
    public function index()
    {
        Auth::logout();
        return redirect('/');
    }
}
