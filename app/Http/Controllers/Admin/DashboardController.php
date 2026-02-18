<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\Project;
use App\Models\System;
use App\Models\Technology;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'blog_posts' => BlogPost::count(),
            'projects' => Project::count(),
            'technologies' => Technology::count(),
            'systems' => System::count(),
            'unread_messages' => ContactSubmission::unread()->count(),
            'total_messages' => ContactSubmission::count(),
        ];

        $recentPosts = BlogPost::latest()->take(5)->get();
        $recentMessages = ContactSubmission::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentMessages'));
    }
}
