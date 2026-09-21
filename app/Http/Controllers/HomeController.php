<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Client;
use App\Models\Project;
use App\Models\System;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::availableIn()->published()->featured()->orderBy('sort_order')->take(3)->get();
        $latestPosts = BlogPost::availableIn()->published()->where('is_technical', false)->latest('published_at')->take(3)->get();
        $systems = System::availableIn()->published()->orderBy('sort_order')->take(4)->get();
        $clients = Client::published()->orderBy('sort_order')->get();

        return view('home', compact('featuredProjects', 'latestPosts', 'systems', 'clients'));
    }
}
