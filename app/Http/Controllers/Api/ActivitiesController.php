<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use Illuminate\Support\Collection;

/**
 * Activites API controller.
 *
 * @version 2.0.0
 * @author  Gustavo Straube <gustavo@straube.co>
 */
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

    public function store(ActivityRequest $request): Activity
    {
        return Activity::create($request->validated());
    }

    public function update(ActivityRequest $request, Activity $activity): Activity
    {
        $activity->update($request->validated());
        return $activity;
    }
}
