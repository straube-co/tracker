<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ManualTimeRequest;
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
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
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

    public function store(ManualTimeRequest $request)
    {
        Time::create([
            'task_id' => $request->task_id,
            'user_id' => Auth::id(),
            'activity_id' => $request->activity_id,
            'started' => $request->started,
            'finished' => $request->finished,
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

    public function update(ManualTimeRequest $request, Time $time)
    {
        $time->update([
            'task_id' => $request->task_id,
            'user_id' => Auth::id(),
            'activity_id' => $request->activity_id,
            'started' => $request->started,
            'finished' => $request->finished,
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
