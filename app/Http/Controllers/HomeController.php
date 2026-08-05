<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\System;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::inLocale()->published()->featured()->orderBy('sort_order')->take(3)->get();
        $latestPosts = BlogPost::inLocale()->published()->where('is_technical', false)->latest('published_at')->take(3)->get();
        $systems = System::inLocale()->published()->orderBy('sort_order')->take(4)->get();

        return view('home', compact('featuredProjects', 'latestPosts', 'systems'));
    }
}
