<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\System;
use App\Models\Technology;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::published()->featured()->orderBy('sort_order')->take(3)->get();
        $latestPosts = BlogPost::published()->latest('published_at')->take(3)->get();
        $systems = System::published()->orderBy('sort_order')->take(4)->get();
        $technologies = Technology::orderBy('sort_order')->take(12)->get();

        return view('home', compact('featuredProjects', 'latestPosts', 'systems', 'technologies'));
    }
}
