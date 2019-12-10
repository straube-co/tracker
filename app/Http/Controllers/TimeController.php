<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Project;
use App\Report;
use App\Task;
use App\Time;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Time controller.
 *
 * @version 2.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class TimeController extends Controller
{

    // public function index(Request $request, string $format = null)
    // {
    //     $format = in_array($format, [ 'html', 'csv' ]) ? $format : 'html';
    //
    //     // TODO: Validate data. Using a form request is probably a good solution.
    //
    //     $report = new Report([
    //         'filter' => $request->all(),
    //     ]);
    //
    //     if ($format === 'csv') {
    //         $contents = $report->getResultsAsCsvString();
    //         $name = 'tracker-' . Carbon::now()->format('Ymd-His') . '.csv';
    //         return response()->streamDownload(function () use ($contents) {
    //             echo $contents;
    //         }, $name);
    //     }
    //
    //     $summary = $report->getSummary();
    //     if (Auth::user()->can('report')) {
    //         $times = $report->getPaginatedResults()->appends($request->all());
    //     } else {
    //         $times = Time::where('user_id', Auth::id())->paginate(20)->appends($request->all());
    //     }
    //
    //     $activities = Activity::orderBy('name')->get();
    //     $projects = Project::orderBy('name')->get();
    //     $tasks = Task::orderBy('name')->get();
    //     $users = User::orderBy('name')->get();
    //
    //     $data = [
    //         'activities' => $activities,
    //         'projects' => $projects,
    //         'tasks' => $tasks,
    //         'users' => $users,
    //         'summary' => $summary,
    //         'times' => $times,
    //     ];
    //
    //     return view('time.index', $data);
    // }

    /**
     * Store a report for sharing.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *  @SuppressWarnings(PHPMD.StaticAccess)
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $this->authorize('report');
    //
    //     $report = Report::create([
    //         'name' => $request->name,
    //         'code' => str_random(20),
    //         'filter' => $request->all(),
    //     ]);
    //
    //     return redirect()->route('report.show', $report->code);
    // }
}
