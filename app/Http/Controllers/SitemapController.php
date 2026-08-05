<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\System;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Static routes and how often they are expected to change.
     */
    private const STATIC_ROUTES = [
        'home' => ['weekly', '1.0'],
        'blog.index' => ['weekly', '0.8'],
        'projects.index' => ['monthly', '0.8'],
        'systems.index' => ['monthly', '0.8'],
        'contact' => ['yearly', '0.7'],
    ];

    public function index(): Response
    {
        $urls = collect();

        foreach (self::STATIC_ROUTES as $name => [$changefreq, $priority]) {
            $urls->push([
                'loc' => route($name),
                'lastmod' => null,
                'changefreq' => $changefreq,
                'priority' => $priority,
            ]);
        }

        $collections = [
            [BlogPost::published()->get(), 'blog.show', 'monthly', '0.7'],
            [Project::published()->get(), 'projects.show', 'yearly', '0.6'],
            [System::published()->get(), 'systems.show', 'yearly', '0.6'],
        ];

        foreach ($collections as [$models, $routeName, $changefreq, $priority]) {
            foreach ($models as $model) {
                $urls->push([
                    'loc' => route($routeName, $model),
                    'lastmod' => $model->updated_at?->toAtomString(),
                    'changefreq' => $changefreq,
                    'priority' => $priority,
                ]);
            }
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
