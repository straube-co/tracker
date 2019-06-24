<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Report;
use App\Time;

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

        $summaryQuery = clone $query;

        $times = $query->paginate();

        $grouped = $summaryQuery->get()->groupBy('activity_id')->map(function($times, $activity_id) {

            $now = new Carbon('00:00');
            $start = clone $now;

            return $times->reduce(function($diff, $time) {
                if($time->finished !== NULL) {
                    return $diff->add($time->finished->diff($time->started));
                }
                return $diff;
            }, $now)->diffAsCarbonInterval($start);
        });

        $data = [
            'report' => $report,
            'times' => $times,
            'grouped' => $grouped,
        ];

        // $report->name;
        // $report->filter['project_id'];

        return view('report.share', $data);
    }
}
