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

class ReportController extends Controller
{
    public function index()
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
        $users = Cache::remember('users', 1, function () {
            return User::get();
        });

        $request = request();

        $query = Time::select('times.*')->orderBy('started', 'desc');

        if (($activity = $request->activity_id)) {
            $query->where('activity_id', $activity);
        }
        if (($project = $request->project_id)) {
            $query->whereHas('task', function ($query) use ($project) {

                $query->where('project_id', $project);
            });
        }
        if (($task = $request->task_id)) {
            $query->where('task_id', $task);
        }
        if (($user = $request->user_id)) {
            $query->where('user_id', $user);
        }
        if (($started = $request->started)) {
            $query->where('started', '>=', $started);
        }
        if (($finished = $request->finished)) {
            $query->where('finished', '<=', $finished);
        }

        $times = $query->paginate();

        $data = [
            'activities' => $activities,
            'projects' => $projects,
            'tasks' => $tasks,
            'users' => $users,
            'started' => $started,
            'finished' => $finished,
            'times' => $times,
        ];

        return view('report.index', $data);
    }

    public function store(Request $request)
    {
        $report = Report::create([
            'name' => $request->name,
            'code' => str_random(20),
            //criando um array json
            'filter' => [
                'project_id' => $request->project_id,
                'task_id' => $request->task_id,
                'user_id' => $request->user_id,
                'activity_id' => $request->activity_id,
                'started' => $request->started,
                'finished' => $request->finished,
            ]
        ]);

        return redirect()->route('share.show', ($report->code));
    }
}
