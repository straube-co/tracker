<?php

namespace App\Http\Controllers;

use App\Report;
use App\Time;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Times controller.
 *
 * @version 2.0.0
 * @author  Lucas Cardoso <lucas@straube.co>
 * @author  Gustavo Straube <gustavo@straube.co>
 */
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
     * Show the time tracking page.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request): Renderable
    {
        $report = Report::getDefaultReport($request->user());
        $times = Time::fromReport($report)->with('project', 'activity', 'user')->paginate(50);

        $data = [
            'report' => $report,
            'times' => $times,
        ];
        return view('times.index', $data);
    }

    /**
     * Stop a time that has not already finished.
     *
     * @param  \App\Time $time
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stop(Time $time): RedirectResponse
    {
        if (!empty($time->finished)) {
            abort(409, __('It\'s not possible to stop a time that has already finished.'));
        }

        $time->update([ 'finished' => Carbon::now() ]);

        return redirect()->back();
    }
}
