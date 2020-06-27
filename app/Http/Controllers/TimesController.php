<?php

namespace App\Http\Controllers;

use App\Report;
use App\Time;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TimesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the time tracking report page.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request): Renderable
    {
        $reports = Report::select('id', 'name')->orderBy('name')->pluck('name', 'id');
        $report = $this->getReportFromRequest($request);
        $times = Time::fromReport($report)->with('project', 'activity', 'user')->paginate(50);

        $data = [
            'reports' => $reports,
            'report' => $report,
            'times' => $times,
        ];
        return view('times.index', $data);
    }

    /**
     * Get the report to show based on the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Report
     */
    private function getReportFromRequest(Request $request): Report
    {
        if (!empty($request->report_id)) {
            return Report::find($request->report_id);
        }

        $filter = $request->filter;
        if (!empty($filter)) {
            return new Report([ 'name' => 'Custom report', 'filter' => $filter ]);
        }

        return Report::getDefaultReport($request->user());
    }
}
