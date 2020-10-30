<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Collection;

/**
 * Projects API controller.
 *
 * @version 2.0.0
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

    public function index(): Collection
    {
        return Project::orderBy('name')->get();
    }

    public function store(ProjectRequest $request): Project
    {
        return Project::create($request->validated());
    }

    public function update(ProjectRequest $request, Project $project): Project
    {
        $project->update($request->validated());
        return $project;
    }
}
