<?php

namespace App\Http\Controllers;

use App\Point;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Point controller.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class PointController extends Controller
{
    public function index()
    {
        $points = Point::where('user_id', Auth::id())->get();

        $data = [
            'points' => $points,
        ];

        return view('point.index', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'entry' => 'required|date_format:Y-m-d H:i:s',
        ]);

        Point::create([
            'user_id' => Auth::id(),
            'entry' => $validatedData['entry'],
        ]);

        return redirect()->route('point.index');
    }

    public function update(Point $point)
    {
        $point->update([
            'exit' => Carbon::now(),
        ]);

        return redirect()->route('point.index');
    }
}
