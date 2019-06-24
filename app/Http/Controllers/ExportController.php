<?php

namespace App\Http\Controllers;

use App\Project;
use App\Support\Formatter;
use App\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ExportController extends Controller
{

    public function store()
    {
        $request = request();

        $query = Time::reportFromRequest($request);

        $times = $query->get();

        $tmpfname = tempnam("/tmp", "times.csv");

        $name = 'report-' . Carbon::now()->format('Y-m-d');

        if ($request->project_id) {
            $name .= '-' . Str::slug(Project::find($request->project_id)->name);
        }

        $name .= '.csv';

        $out = fopen($tmpfname, 'w');

        fputcsv($out, [
            'Project',
            'Task',
            'Activity',
            'User',
            'Started',
            'Finished',
            'Total',
        ]);

        foreach ($times as $time) {
            fputcsv($out, [
                $time->task->project->name,
                $time->task->name,
                $time->activity->name,
                $time->user->name,
                $time->started,
                $time->finished,
                $time->finished ? Formatter::intervalTime($time->finished->diffAsCarbonInterval($time->started)) : '-',
            ]);
        }

        fclose($out);

        return response()->download($tmpfname, $name);
    }
}
