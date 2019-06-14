<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Time;
use App\Project;
use App\Activity;
use App\Task;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class AutoController extends Controller
{

    public function create()
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
        $notFinishedTime = Time::where('finished', null)->count() > 0;

        $data = [
            'projects' => $projects,
            'tasks' => $tasks,
            'activities' => $activities,
            'notFinishedTime' => $notFinishedTime,
        ];
        return view('auto.index', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'activity_id' => 'required',
        ]);

        $time = Time::where('user_id', $request->id)->where('finished', null)->count() == 0;

        if ($time) {
            Time::create([
                'task_id' => $validatedData['task_id'],
                'user_id' => $request->session()->get('auth.id'),
                'activity_id' => $validatedData['activity_id'],
                'started' => Carbon::now(),
                'finished' => null,
            ]);
        }
        return redirect()->route('time.index');
    }

    public function update(Time $time)
    {
        $time->update([
            'finished' => Carbon::now(),
        ]);
        $time->save();

        return redirect()->route('time.index');
    }
}
