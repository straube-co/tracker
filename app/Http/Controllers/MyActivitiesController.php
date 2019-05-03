<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Activity;
use App\Project;
use App\Task;
use App\Time;
use App\User;
use App\Report;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class MyActivitiesController extends Controller
{
    public function index()
    {
        //
        $times = Time::with('task', 'task.project', 'activity')
            ->where('user_id', session('auth.id'))
            ->orderBy('started', 'desc')
            ->paginate();

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
            'times' => $times,
            'projects' => $projects,
            'tasks' => $tasks,
            'activities' => $activities,
        ];
        return view('myActivities.index', $data);
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
        return redirect()->route('my.index');
    }

    public function edit(Time $time)
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
            'time' => $time,
            'activities' => $activities
        ];
        return view('myActivities.edit', $data);
    }

    public function update(Request $request, Time $time)
    {
        $validatedData = $request->validate([
            'task_id' => 'exists:tasks,id',
            'started' => 'date_format:Y-m-d H:i:s',
            'finished' => 'date_format:Y-m-d H:i:s|after_or_equal:started',
        ]);

        $time->update([
            'task_id' => $validatedData['task_id'],
            'activity_id' => $request->activity_id,
            'started' => $validatedData['started'],
            'finished' => $validatedData['finished'],
        ]);
        $time->save();

        return redirect()->route('my.index');
    }

    public function destroy(Time $time)
    {
        $time->delete();

        return redirect()->route('my.index');
    }
}
