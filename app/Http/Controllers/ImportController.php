<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Activity;
use App\Project;
use App\Task;
use App\Time;
use App\User;

class ImportController extends Controller
{

    public function index()
    {
        $projects = Project::get();

        $data = [
            'projects' => $projects,
        ];

        return view('import.import', $data);
    }

    public function store(Request $request)
    {
        $activities = Activity::get();

        //seeking out project per project_id(request).
        $project = Project::find($request->project_id);

        //search on tasks, the project_id equal project->id.
        $tasks = Task::where('project_id', $project->id)->get();

        $file = $request->file('import_file')->openFile();
        $first = true;
        $lines =[];

        while (!$file->eof()) {
            $line = $file->fgetcsv();

            if ($first) {
                //removing first line in the array.
                $first = false;
                continue;
            }

            //removing last position in the array void(NULL).
            if (count(array_filter($line)) === 0) {
                continue;
            }

            //inserting lines at the array.
            $lines[] = $line;
        }

        $data = [
            'activities' => $activities,
            'project' => $project,
            'tasks' => $tasks,
            'lines' => $lines,
        ];

        return view('import.taskselect', $data);
    }

    public function update(Request $request, $id)
    {
        foreach($request->time as $time) {

            //decode line to access the schedules.
            $jsonarr = json_decode($time["line"], true);

            //search on User, the name equal the position[2] in the array.
            $user = User::where('name', $jsonarr[2])->first();

            //search on Time, the informations the user_id equal $user->id. Search per 'started' equal $jsonarr[6].
             $usertime = Time::where('user_id', $user->id)->where('started', Carbon::parse($jsonarr[6]))->count();  //count return 0 or 1.

             if($usertime > 0){
                 continue;
             }
             else {
                 Time::create([
                     'project_id' => $id,
                     'task_id' => $time["task_id"],
                     'user_id' => $user->id,
                     'activity_id' => $time["activity_id"],

                     //using Carbon for specific date format.
                     'started' => Carbon::parse($jsonarr[6]),
                     //entering in json to access the specifield position in the array[].
                     'finished' => Carbon::parse($jsonarr[7]),
                 ]);
             }
        }
        return view('layouts.home');
    }
}
