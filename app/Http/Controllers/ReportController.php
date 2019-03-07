<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Project;
use App\Task;
use App\Time;
use App\User;

class ReportController extends Controller
{
    public function index()
    {
        $activities = Activity::get();
        $projects = Project::get();
        $tasks = Task::get();
        $users = User::get();

        $request = request();

        $query = Time::select('times.*');
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

        $times = $query->get();

        $data = [
            'activities' => $activities,
            'projects' => $projects,
            'tasks' => $tasks,
            'times' => $times,
            'users' => $users,
        ];

        return view('report.index', $data);
    }

}
