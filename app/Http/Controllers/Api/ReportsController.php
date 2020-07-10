<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Report;

/**
 * Reports API controller.
 *
 * @version 2.0.0
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

    public function store(ReportRequest $request): Report
    {
        $report = Report::create($request->validated());
        $report->url = route('reports.index', [ 'report_id' => $report->id ]);

        return $report;
    }
}
