<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Client;
use App\Models\ContactSubmission;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\System;
use App\Models\Technology;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'blog_posts' => BlogPost::count(),
            'projects' => Project::count(),
            'technologies' => Technology::count(),
            'systems' => System::count(),
            'clients' => Client::count(),
            'users' => User::count(),
            'unread_messages' => ContactSubmission::unread()->count(),
            'total_messages' => ContactSubmission::count(),
            'unread_quotes' => QuoteRequest::unread()->count(),
        ];

        $recentPosts = BlogPost::latest()->take(5)->get();
        $recentMessages = ContactSubmission::latest()->take(5)->get();
        $recentQuotes = QuoteRequest::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentMessages', 'recentQuotes'));
    }
}
