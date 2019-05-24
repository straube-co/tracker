<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Activity;
use App\Project;
use App\Task;
use App\Time;
use App\User;

class ExportController extends Controller {

    // public function store()
    // {
    //     $times = Cache::remember('times', 1, function () {
    //         return Time::get();
    //     });
    //
    //     $name = "Arquivo CSV";
    //
    //     $fp = fopen('arquivo.csv', 'w');
    //
    //     foreach ($times as $time) {
    //         fputcsv($fp, array($time->project_id,));
    //         fputcsv($fp, array($time->task_id));
    //         fputcsv($fp, array($time->activity_id));
    //         fputcsv($fp, array($time->started));
    //         fputcsv($fp, array($time->finished));
    //     }
    //
    //     fclose($fp);
    //
    //     return response()->download($fp, $name);
    // }
}
