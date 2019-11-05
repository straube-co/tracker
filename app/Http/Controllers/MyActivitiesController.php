<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Activity;
use App\Project;
use Carbon\Carbon;
use App\Task;
use App\Time;
use App\User;
use App\Report;

/**
 * My Activity controller.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class MyActivitiesController extends Controller
{
    public function index()
    {
        //
        $times = Time::with('task', 'task.project', 'activity')
            ->where('user_id', Auth::id())
            ->orderBy('started', 'desc')
            ->paginate();

        $activities = Activity::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $tasks = Task::orderBy('name')->get();

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
            'project_id' => 'required',
            'task_id' => 'required|exists:tasks,id',
            'activity_id' => 'required',
            'started' => 'required|date_format:Y-m-d H:i:s',
            'finished' => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:started',
                'before:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);

        Time::create([
            'task_id' => $validatedData['task_id'],
            'user_id' => Auth::id(),
            'activity_id' => $validatedData['activity_id'],
            'started' => $validatedData['started'],
            'finished' => $validatedData['finished'],
        ]);
        return redirect()->route('my.index');
    }

    public function edit(Time $time)
    {
        $activities = Activity::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $tasks = Task::orderBy('name')->get();

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
            'project_id' => 'required',
            'task_id' => 'required|exists:tasks,id',
            'activity_id' => 'required',
            'started' => 'required|date_format:Y-m-d H:i:s',
            'finished' => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after_or_equal:started',
                'before:' . Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);

        $time->update([
            'task_id' => $validatedData['task_id'],
            'user_id' => Auth::id(),
            'activity_id' => $validatedData['activity_id'],
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
