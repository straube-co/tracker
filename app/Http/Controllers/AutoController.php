<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Time;
use App\Project;
use App\Activity;
use App\Task;

/**
 * Auto controller.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
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
            'task_name' => 'required',
            'activity_id' => 'required',
        ]);

        $task = Task::create([
            'name' => $validatedData['task_name'],
            'project_id' => $request->project_id,
        ]);

        DB::transaction(function () use ($validatedData, $task) {

            $time = Time::where('user_id', Auth::id())->where('finished', null)->count() == 0;

            if (!$time) {
                return;
            }

            Time::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'activity_id' => $validatedData['activity_id'],
                'started' => Carbon::now(),
                'finished' => null,
            ]);
        });

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
