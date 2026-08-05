<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::published()->orderBy('sort_order')->paginate(12);

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        if (! $project->is_published) {
            abort(404);
        }

        return view('projects.show', compact('project'));
    }
}
