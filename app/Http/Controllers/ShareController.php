<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Time;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ShareController extends Controller
{
    public function show(Report $report)
    {
        //
        $query = Time::orderBy('started', 'desc');

        if (($activity = $report->filter['activity_id'])) {
            $query->where('activity_id', $activity);
        }
        if (($project = $report->filter['project_id'])) {
            $query->whereHas('task', function ($query) use ($project) {

                $query->where('project_id', $project);
            });
        }
        if (($task = $report->filter['task_id'])) {
            $query->where('task_id', $task);
        }
        if (($user = $report->filter['user_id'])) {
            $query->where('user_id', $user);
        }
        if (($started = $report->filter['started'])) {
            $query->where('started', '>=', $started);
        }
        if (($finished = $report->filter['finished'])) {
            $query->where('finished', '<=', $finished);
        }

        $times = $query->paginate();

        $data = [
            'report' => $report,
            'times' => $times,
        ];

        // $report->name;
        // $report->filter['project_id'];

        return view('report.share', $data);
    }
}
