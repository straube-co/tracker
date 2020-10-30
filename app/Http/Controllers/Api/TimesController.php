<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimeRequest;
use App\Models\Time;
use Illuminate\Support\Collection;

/**
 * Times API controller.
 *
 * @version 2.0.0
 * @author  Gustavo Straube <gustavo@straube.co>
 */
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

    public function update(TimeRequest $request, Time $time): Time
    {
        $time->update($request->validated());
        return $time;
    }

    public function destroy(Time $time)
    {
        $time->delete();
        return null;
    }
}
