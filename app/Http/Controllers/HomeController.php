<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Activity;
use App\Project;
use App\Task;
use App\Time;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class HomeController extends Controller
{
    public function index()
    {
        $times =  Cache::remember('times', 1, function () {
            return Time::get();
        });

        $data = [
            'times' => $times,
        ];

        return view('home', $data);
    }
}
