<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Time;
use App\Project;
use App\Activity;
use App\Task;

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

        $data = [
            'projects' => $projects,
            'tasks' => $tasks,
            'activities' => $activities,
        ];
        return view('auto.index', $data);
    }

    public function store(Request $request)
    {
        $time = Time::where('user_id', $request->id)->where('finished', NULL)->count();

         if($time == 0){
             Time::create([
                 'task_id' => $request->task_id,
                 'user_id' => $request->session()->get('auth.id'),
                 'activity_id' => $request->activity_id,
                 'started' => Carbon::now(),
                 'finished' => NULL,
             ]);
             return redirect()->route('time.index');
         }else {
             return redirect()->route('time.index');
          }
    }

    public function update($id)
    {
        $time = Time::find($id);

        $time->update([
            'finished' => Carbon::now(),
        ]);
        $time->save();

        return redirect()->route('time.index');
    }
}
