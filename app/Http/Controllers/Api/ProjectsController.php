<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Project;
use Illuminate\Support\Collection;

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
}
