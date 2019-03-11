<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Project;
use App\Task;
use App\Time;
use App\User;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.import');
    }

    public function import(Request $request)
    {
        $file = $request->file('import_file')->openFile();
        while (!$file->eof()) {
            echo $file->fgetcsv();
        }
    }
}
