<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

/**
 * Projects controller.
 *
 * @version 2.0.0
 * @author  Lucas Cardoso <lucas@straube.co>
 * @author  Gustavo Straube <gustavo@straube.co>
 */
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

    public function index(string $status = null): Renderable
    {
        $query = Project::selectTrackedTime()->orderBy('name');
        if ($status === 'archived') {
            $query->onlyTrashed();
        }
        $projects = $query->get();

        $data = [
            'status' => $status,
            'projects' => $projects,
        ];
        return view('projects.index', $data);
    }

    public function archive(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->back();
    }

    public function restore(Project $project): RedirectResponse
    {
        $project->restore();

        return redirect()->back();
    }
}
