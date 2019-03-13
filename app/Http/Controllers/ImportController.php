<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;
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
        $project = Project::find($request->project_id);     //buscando project por project_id do request.
        $tasks = Task::where('project_id', $project->id)->get();    //buscando apenas as tarefas que estão relacionadas a um projeto expecifico.

        $file = $request->file('import_file')->openFile();
        $first = true;
        $lines =[];     //declarando array vazio para colocar as lines dentro.

        while (!$file->eof()) {
            $line = $file->fgetcsv();

            if ($first) {   //remove first line.
                $first = false;
                continue;
            }
            if (count(array_filter($line)) === 0) {     //removendo o array vazio para tirar select sobrando na view.
                continue;
            }
            $lines[] = $line;   //inserindo lines no array vazio.
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

            Time::create([
                'project_id' => $id,
                'task_id' => $time["task_id"],
                'activity_id' => $time["activity_id"],
                'started' => Carbon\Carbon::parse(),
                'finished' => Carbon\Carbon::parse(),
            ]);
        }
    }
}
