<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DateTimeZone;

class TimezonesController extends Controller
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

    public function index(): array
    {
        return DateTimeZone::listIdentifiers();
    }
}
