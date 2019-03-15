<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use App\Project;
use App\Activity;
use App\Task;

class TimeController extends Controller
{

    public function index()
    {
        // 
        $times = Time::orderBy('started', 'desc')->get();

        $data = [
            'times' => $times,
        ];

        return view('time.index', $data);
    }

    public function create()
    {
        $activities = Activity::get();
        $projects = Project::get();
        $tasks = Task::get();

        $data = [
            'projects' => $projects,
            'tasks' => $tasks,
            'activities' => $activities,
        ];
        return view('time.create', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'exists:tasks,id',
            'started' => 'date_format:Y-m-d H:i:s',
            'finished' => 'date_format:Y-m-d H:i:s|after_or_equal:started',
        ]);

        Time::create([
            'task_id' => $request->task_id,
            'user_id' => $request->session()->get('auth.id'),
            'activity_id' => $request->activity_id,
            'started' => $request->started,
            'finished' => $request->finished,
        ]);
        return redirect()->route('time.index');
    }

    public function edit($id)
    {
        $activities = Activity::get();
        $projects = Project::get();
        $tasks = Task::get();
        $time = Time::find($id);

        $data = [
            'projects' => $projects,
            'tasks' => $tasks,
            'time' => $time,
            'activities' => $activities
        ];
        return view('time.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'task_id' => 'exists:tasks,id',
            'started' => 'date_format:Y-m-d H:i:s',
            'finished' => 'date_format:Y-m-d H:i:s|after_or_equal:started',
        ]);

        $time = Time::find($id);

        $time->update([
            'task_id' => $request->task_id,
            'activity_id' => $request->activity_id,
            'started' => $request->started,
            'finished' => $request->finished,
        ]);
        $time->save();

        return redirect()->route('time.index');
    }

    public function destroy($id)
    {
        $time = Time::find($id);
        $time->delete();

        return redirect()->route('time.index');
    }
}
