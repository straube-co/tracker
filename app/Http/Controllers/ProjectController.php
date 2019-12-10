<?php

namespace App\Http\Controllers;

use App\Project;

use App\Http\Requests\OnlyNameRequest;
use Illuminate\Http\Request;

/**
 * Project controller.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ProjectController extends Controller
{
    public function store(OnlyNameRequest $request)
    {
        Project::create([
            'name' => $request->name,
        ]);

        return back();
    }
}
