<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Support\Formatter;

use Carbon\Carbon;
use App\Report;
use App\Time;

class ExportController extends Controller {

     public function store(Report $report)
     {

         $query = Time::orderBy('started', 'desc');

         if (($activity = $report->filter['activity_id'])) {
             $query->where('activity_id', $activity);
         }
         if (($project = $report->filter['project_id'])) {
             $query->whereHas('task', function ($query) use ($project) {

                 $query->where('project_id', $project);
             });
         }
         if (($task = $report->filter['task_id'])) {
             $query->where('task_id', $task);
         }
         if (($user = $report->filter['user_id'])) {
             $query->where('user_id', $user);
         }
         if (($started = $report->filter['started'])) {
             $query->where('started', '>=', $started);
         }
         if (($finished = $report->filter['finished'])) {
             $query->where('finished', '<=', $finished);
         }

         $times = $query->get();

         $tmpfname = tempnam ("/tmp", "times.csv");

         foreach ($times as $time) {
             $name = Carbon::now()->format('Y-m-d') . ' - ' . $time->task->project->name . '.csv';
         }


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
