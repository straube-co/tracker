<?php

namespace App\Http\Controllers;

use App\Point;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Point report controller.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class PointReportController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get();
        $query = Point::select('user_id', DB::raw('DATE(started) AS date_entry'), DB::raw('SUM(TIMESTAMPDIFF(MINUTE, started, finished)) AS date_time'))
                                ->whereNotNull('finished')->groupBy('date_entry')->groupBy('user_id');

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
        $validatedData = $request->validate([
            'started' => 'required|date_format:Y-m-d H:i:s',
        ]);

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
}
