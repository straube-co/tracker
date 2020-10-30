<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use App\Models\Report;
use App\Models\Time;
use App\Models\User;
use App\Support\Formatter;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Reports controller.
 *
 * @version 2.0.0
 * @author  Lucas Cardoso <lucas@straube.co>
 * @author  Gustavo Straube <gustavo@straube.co>
 */
class ReportsController extends Controller
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
        $query = Time::fromReport($report);
        $times = (clone $query)->with('project', 'activity', 'user')->paginate(50);
        $grandTotal = 0;
        $totals = (clone $query)->selectActivityTotals()->pluck('total', 'name')->map(function ($total) use (&$grandTotal) {
            $grandTotal += $total;
            return Formatter::intervalFromSeconds($total);
        });
        $grandTotal = Formatter::intervalFromSeconds($grandTotal);

        $data = [
            'reports' => $reports,
            'report' => $report,
            'times' => $times,
            'totals' => $totals,
            'grandTotal' => $grandTotal,
        ];
        return view('reports.index', $data);
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
            // TODO: Validate filters
            return new Report([ 'name' => __('Custom filter'), 'filter' => $filter ]);
        }

        return Report::getDefaultReport($request->user());
    }
}
