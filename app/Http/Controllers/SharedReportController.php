<?php

namespace App\Http\Controllers;

use App\Report;
use App\Support\Formatter;
use App\Time;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;

class ReportsController extends Controller
{

    public function show(string $code, string $format = null): Renderable
    {
        $report = Report::where('code', $code)->first();
        if (empty($report)) {
            abort(404);
        }

        $times = Time::fromReport($report)->with('project', 'activity', 'user')->get();

        if ($format === 'csv') {
            return $this->getTimesAsCsv();
        }

        $data = [
            'report' => $report,
            'times' => $times,
        ];
        return view('reports.shared.show', $data);
    }

    private function getTimesAsCsv(Collection $times): Renderable
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

        foreach ($times as $time) {
            $ellapsed = null;
            if ($time->finished) {
                $ellapsed = Formatter::timeDiff($time->started, $time->finished);
            }
            $rows[] = [
                $time->task->project->name,
                $time->task->name,
                $time->activity->name,
                $time->user->name,
                $time->started,
                $time->finished,
                $ellapsed,
            ];
        }

        $rows = array_map(function ($row) {
            return '"' . implode('","', $row) . '"';
        }, $rows);

        $csv = implode("\n", $rows);
        return response($csv, 200)->header('Content-Type', 'text/csv');
    }
}
