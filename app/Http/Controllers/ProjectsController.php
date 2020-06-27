<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Contracts\Support\Renderable;

class ProjectsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $projects = Project::orderBy('name')->get();
        $data = [
            'projects' => $projects,
        ];

        return view('projects.index', $data);
    }
}
