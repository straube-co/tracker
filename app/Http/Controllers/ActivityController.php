<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Time;
use App\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Cache::remember('activities', 1, function () {
            return Activity::get();
        });

        $data = [
            'activities' => $activities,
        ];

        return view('activities.index', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:35',
        ]);

        Activity::create([
            'id' => $request->id,
            'name' => $validatedData['name'],
        ]);

        //removing items from the cache
        Cache::forget('activities');

        return redirect()->route('activity.index');
    }

    public function edit($id)
    {
        $activity = Activity::find($id);

        $data = [
            'activity' => $activity,
        ];

        return view('activities.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:35',
        ]);

        $activity = Activity::find($id);

        $activity->update([
            'name' => $validatedData['name'],
        ]);
        $activity->save();

        //removing items from the cache
        Cache::forget('activities');

        return redirect()->route('activity.index');
    }

    public function destroy($id)
    {
        $activity = Activity::find($id);
        $activity->delete();

        //removing items from the cache
        Cache::forget('activities');

        return redirect()->route('activity.index');
    }
}
