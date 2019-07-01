<?php

namespace App\Http\Controllers;

use App\Report;
use App\Support\Formatter;
use App\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ShareController extends Controller
{
    public function show(Report $report, string $format = null)
    {
        $format = in_array($format, [ 'html', 'csv' ]) ? $format : 'html';

        $query = $this->buildQuery($report);

        if ($format === 'csv') {
            return $this->getCsv($query);
        }

        $summaryQuery = clone $query;

        $times = $query->paginate();

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
            'report' => $report,
            'times' => $times,
            'grouped' => $grouped,
        ];

        return view('report.share', $data);
    }

    private function buildQuery(Report $report)
    {
        $query = Time::with('activity', 'task', 'task.project')->orderBy('started', 'desc');

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

        return $query;
    }

    private function getCsv($query)
    {
        $rows = [
            [
                'Project',
                'Task',
                'Activity',
                'User',
                'Started',
                'Finished',
                'Ellapsed time',
            ]
        ];

        $results = $query->get();

        foreach ($results as $time) {
            $ellapsed = null;
            if ($time->finished) {
                $ellapsed = Formatter::intervalTime(
                    $time->finished->diffAsCarbonInterval($time->started)
                );
            }
            $rows[] = [
                $time->task->project->name,
                $time->task->name,
                $time->activity->name,
                $time->user->name,
                $time->started_at,
                $time->finished_at,
                $ellapsed,
            ];
        }

        $rows = array_map(function ($row) {
            return '"' . implode('","', $row) . '"';
        }, $rows);

        return response(implode("\n", $rows), 200)
              ->header('Content-Type', 'text/csv');
    }
}
