<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Contracts\Support\Renderable;

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

    public function index(): Renderable
    {
        $activities = Activity::orderBy('name')->get();
        $data = [
            'activities' => $activities,
        ];

        return view('activities.index', $data);
    }
}
