<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::inLocale()->published()->where('is_technical', false)->with('author')->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function show(BlogPost $post)
    {
        if (! $post->is_published) {
            abort(404);
        }

        $relatedPosts = BlogPost::inLocale()->published()->where('is_technical', false)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
