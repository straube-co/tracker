<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Time;
use App\Project;
use App\Activity;
use App\Task;

class TimeController extends Controller
{

    public function index()
    {
        $activities = Cache::remember('activities', 1, function () {
            return Activity::get();
        });

        $projects = Cache::remember('projects', 1, function () {
            return Project::get();
        });
        $tasks = Cache::remember('tasks', 1, function () {
            return Task::get();
        });

        $data = [
            'projects' => $projects,
            'tasks' => $tasks,
            'activities' => $activities,
        ];
        return view('time.index', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'exists:tasks,id',
            'started' => 'date_format:Y-m-d H:i:s',
            'finished' => 'date_format:Y-m-d H:i:s|after_or_equal:started',
        ]);

        Time::create([
            'task_id' => $validatedData['task_id'],
            'user_id' => $request->session()->get('auth.id'),
            'activity_id' => $request->activity_id,
            'started' => $validatedData['started'],
            'finished' => $validatedData['finished'],
        ]);
        return redirect()->route('time.index');
    }
}
