<?php

namespace App\Http\Controllers;

use App\Point;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

/**
 * Point report controller.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class PointReportController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get();

        if (Auth::user()->can('report')) {
            $query = Point::select(
                'user_id',
                DB::raw('DATE(started) AS date_entry'),
                DB::raw('SUM(TIMESTAMPDIFF(MINUTE, started, finished)) AS date_time')
            )
                ->whereNotNull('finished')
                ->groupBy('date_entry')
                ->groupBy('user_id');
        } else {
            $query = Point::select(
                'user_id',
                DB::raw('DATE(started) AS date_entry'),
                DB::raw('SUM(TIMESTAMPDIFF(MINUTE, started, finished)) AS date_time')
            )
                ->whereNotNull('finished')
                ->where('user_id', Auth::id())
                ->groupBy('date_entry')
                ->groupBy('user_id');
        }

        $queryTotal = Point::select(DB::raw('SUM(TIMESTAMPDIFF(MINUTE, started, finished)) AS total'));

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
            $queryTotal->where('user_id', $request->user_id);
        }
        if ($request->started) {
            $query->where('started', '>=', $request->started);
            $queryTotal->where('started', '>=', $request->started);
        }
        if ($request->finished) {
            $query->where('finished', '<=', $request->finished);
            $queryTotal->where('finished', '<=', $request->finished);
        }

        $schedules = $query->get();
        $total = $queryTotal->whereNotNull('finished')->value('total');

        $data = [
            'schedules' => $schedules,
            'users' => $users,
            'total' => $total,
        ];

        return view('point.report', $data);
    }

    public function store(Request $request)
    {
        $finished = Point::select('finished')->where('user_id', Auth::id())->orderBy('finished', 'desc')->first();

        $rules = [
            'started' => [
                'required',
                'date_format:Y-m-d H:i:s',
            ],
        ];

        if ($finished) {
            $rules['started'][] = 'after_or_equal:$finished->finished';
        }

        $validatedData = $request->validate($rules);

        Point::create([
            'user_id' => Auth::id(),
            'started' => $validatedData['started'],
        ]);

        return back();
    }

    public function update(Point $point)
    {
        $point->update([
            'finished' => Carbon::now(),
        ]);

        return back();
    }

    public function print(Request $request)
    {
        $schedules = Point::where('user_id', $request->user)->whereMonth('created_at', $request->month)
            ->whereYear('created_at', $request->year)->get();

        $user = User::where('id', $request->user)->first();

        $data = [
            'schedules' => $schedules,
            'user' => $user,
        ];

        return view('point.print', $data);
    }
}
