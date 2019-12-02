<?php

namespace App\Http\Controllers;

use App\Project;

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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|unique:projects',
        ]);

        Project::create([
            'name' => $validatedData['name'],
        ]);

        return back();
    }
}
