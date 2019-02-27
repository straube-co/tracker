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
        return view('index');
    }

    public function create()
    {
        $projects = Project::get();
        $tasks = Task::get();

        $data = [
            'projects' => $projects,
            'tasks' => $tasks,
        ];
        return view('create', $data);
    }

    public function store(Request $request)
    {
        Time::create([
            'task_id' => $request->taskselect,
            'user_id' => $request->session()->get('auth.id'),
            'started' => $request->hms,
            'finished' => $request->hmf,
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
        return view('edit', $data);
    }

    public function update()
    {


    }

    public function destroy()
    {


    }
}
