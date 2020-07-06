<?php

namespace App\Http\Controllers;

use App\Report;
use App\Support\Formatter;
use App\Time;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;

class SharedReportsController extends Controller
{

    public function show(string $code): Renderable
    {
        $report = $this->getReportFromCode($code);
        $query = $this->getReportQuery($report);
        $times = $query->paginate(50);

        $data = [
            'report' => $report,
            'times' => $times,
        ];
        return view('reports.shared.show', $data);
    }

    public function export(string $code): Response
    {
        $report = $this->getReportFromCode($code);
        $query = $this->getReportQuery($report);
        $times = $query->get();

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
                $time->project->name,
                $time->description,
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

    private function getReportFromCode(string $code): Report
    {
        $report = Report::where('code', $code)->first();
        if (empty($report)) {
            abort(404);
        }

        return $report;
    }

    private function getReportQuery(Report $report): Builder
    {
        return Time::fromReport($report)->with('project', 'activity', 'user');
    }
}
