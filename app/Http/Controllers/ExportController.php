<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use App\Activity;
use App\Project;
use App\Task;
use App\Time;
use App\User;

class ExportController extends Controller {

     public function store()
     {
         $times = Time::get();

         $tmpfname = tempnam ("/tmp", "times.csv");

         $out = fopen($tmpfname, 'w');

             fputcsv($out, array($times));

         fclose($out);

         return response()->download($tmpfname);
     }
}
