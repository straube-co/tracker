<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use App\Project;
use App\Activity;
use App\Task;

class TimeautoController extends Controller
{
    
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
        return view('timeauto.index', $data);
    }

    public function store(Request $request)
    {
        Time::create([
            'task_id' => $request->task_id,
            'user_id' => $request->session()->get('auth.id'),
            'activity_id' => $request->activity_id,

        ]);
        return redirect()->route('time.index');
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
