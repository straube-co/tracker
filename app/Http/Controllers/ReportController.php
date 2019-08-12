<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Project;
use App\Report;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Report controller.
 *
 * @author Lucas Cardoso <lucas@straube.co>
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ReportController extends Controller
{

    /**
     * Generate a report.
     *
     * Filters may be applied to the report based on current request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, string $format = null)
    {
        $format = in_array($format, [ 'html', 'csv' ]) ? $format : 'html';

        $report = new Report([
            'filter' => $request->all(),
        ]);

        if ($format === 'csv') {
            $contents = $report->getResultsAsCsvString();
            $name = 'tracker-' . Carbon::now()->format('Ymd-His') . '.csv';
            return response()->streamDownload(function () use ($contents) {
                echo $contents;
            }, $name);
        }

        $summary = $report->getSummary();
        $times = $report->getPaginatedResults()->appends($request->all());

        $activities = Activity::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $tasks = Task::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        $data = [
            'activities' => $activities,
            'projects' => $projects,
            'tasks' => $tasks,
            'users' => $users,
            'summary' => $summary,
            'times' => $times,
        ];
        return view('report.index', $data);
    }

    /**
     * Store a report for sharing.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $report = Report::create([
            'name' => $request->name,
            'code' => str_random(20),
            'filter' => $request->all(),
        ]);

        return redirect()->route('report.show', $report->code);
    }

    /**
     * Show a stored (shared) report.
     *
     * @param  \App\Report $report
     * @param  string $format
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Report $report, string $format = null)
    {
        $format = in_array($format, [ 'html', 'csv' ]) ? $format : 'html';

        if ($format === 'csv') {
            $contents = $report->getResultsAsCsvString();
            return response($contents, 200)->header('Content-Type', 'text/csv');
        }

        $summary = $report->getSummary();
        $times = $report->getPaginatedResults();

        $activities = Activity::orderBy('name')->get();

        $data = [
            'report' => $report,
            'activities' => $activities,
            'summary' => $summary,
            'times' => $times,
        ];
        return view('report.show', $data);
    }
}
