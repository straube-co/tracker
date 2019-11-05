<?php

namespace App\Http\Controllers;

use App\Point;
use App\User;
use Illuminate\Http\Request;
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
        $query = Point::select('user_id', DB::raw('DATE(entry) AS date_entry'), DB::raw('SUM(TIMESTAMPDIFF(MINUTE, `entry`, `exit`)) AS date_time'))
                                ->whereNotNull('exit')->groupBy('date_entry')->groupBy('user_id');

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->entry) {
            $query->where('entry', '>=', $request->entry);
        }
        if ($request->exit) {
            $query->where('exit', '<=', $request->exit);
        }

        $points = $query->get();

        $data = [
            'points' => $points,
            'users' => $users,
        ];

        return view('point.report', $data);
    }
}
