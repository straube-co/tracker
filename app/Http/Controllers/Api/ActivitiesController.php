<?php

namespace App\Http\Controllers\Api;

use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ActivitiesController extends Controller
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
        return Activity::orderBy('name')->get();
    }
}