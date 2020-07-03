<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimeRequest;
use App\Time;
use Illuminate\Support\Collection;

class TimesController extends Controller
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

    public function store(TimeRequest $request): Time
    {
        return Time::create($request->validated());
    }
}