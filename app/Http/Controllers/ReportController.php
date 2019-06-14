<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Activity;
use App\Project;
use App\Task;
use App\Time;
use App\User;
use App\Report;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
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

        $query = Time::reportFromRequest($request);

        $summaryQuery = clone $query;

        $times = $query->paginate()->appends($request->all());

        $grouped = $summaryQuery->get()->groupBy('activity_id')->map(function ($times) {

            $now = new Carbon('00:00');
            $start = clone $now;

            return $times->reduce(function ($diff, $time) {
                if ($time->finished !== null) {
                    return $diff->add($time->finished->diff($time->started));
                }
                return $diff;
            }, $now)->diffAsCarbonInterval($start);
        });

        $data = [
            'activities' => $activities,
            'projects' => $projects,
            'tasks' => $tasks,
            'users' => $users,
            'started' => $request->started,
            'finished' => $request->finished,
            'times' => $times,
            'grouped' => $grouped,
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
