<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use App\Project;
use App\Task;

class TimeController extends Controller
{

    public function index()
    {
        $times = Time::get();

        $data = [
            'times' => $times,
        ];

        return view('time.index', $data);
    }

    public function create()
    {
        $projects = Project::get();
        $tasks = Task::get();

        $data = [
            'projects' => $projects,
            'tasks' => $tasks,
        ];
        return view('time.create', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'task_id' => 'exists:tasks,id',
            'started' => 'date_format:H:i',
            'finished' => 'date_format:H:i|after:started',
        ]);

        Time::create([
            'task_id' => $request->task_id,     // pegando dados do create select
            'user_id' => $request->session()->get('auth.id'),
            'started' => $request->started,
            'finished' => $request->finished,
        ]);
        return redirect()->route('time.index');
    }

    public function edit($id)
    {
        $projects = Project::get();
        $tasks = Task::get();
        $time = Time::find($id);

        $data = [
            'projects' => $projects,
            'tasks' => $tasks,
            'time' => $time,
        ];
        return view('time.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'task_id' => 'exists:tasks,id',
            'started' => 'date_format:H:i',
            'finished' => 'date_format:H:i|after:started',
        ]);

        $time = Time::find($id);

        $time->update([
            'task_id' => $request->task_id,     // pegando dados do edit select
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
