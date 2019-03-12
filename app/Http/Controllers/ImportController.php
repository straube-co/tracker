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
        $file = $request->file('import_file')->openFile();                      //abrindo arquivo que está sendo importado.
        $first = true;

        while (!$file->eof()) {
            $line = $file->fgetcsv();                                           //exibindo o arquivo uma linha por vez dentro do while.

            if ($first) {
                $first = false;                                                 //ignorando a primeira linha e continuando.
                continue;
            }

            $count = \App\Task::where('name', $file[0])->count();

            if($count ===  0){

                Time::create([
                    'project_id' => $request->project_id,                          //recebendo project_id do select.
                    'user_id' => $request->session()->get('auth.id'),
                    'activity_id' => 5,                                            //associando activit_id com o id de "OUTRAS" nas atividades.
                    'started' => Carbon\Carbon::parse($line[6]),
                    'finished' => Carbon\Carbon::parse($line[7]),                  //acesando a linha [5]e[6] do array e passando o formato esperado de data.
             ]);
            }
        }
    }
}
