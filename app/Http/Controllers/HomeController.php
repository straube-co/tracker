<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Project;
use App\Task;
use App\Time;

class HomeController extends Controller
{
    public function index()
    {
        $times = Time::get();

        $data = [
            'times' => $times,
        ];

        return view('layouts.home', $data);
    }
}
