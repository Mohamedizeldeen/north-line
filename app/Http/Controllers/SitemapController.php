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
        'clients.index' => ['monthly', '0.6'],
        'quote' => ['yearly', '0.7'],
        'contact' => ['yearly', '0.7'],
    ];

    public function index(): Response
    {
        $urls = collect();
        $locales = array_keys(config('site.locales'));

        // Each static route is generated once per locale explicitly — route()
        // otherwise falls back to the ambient request locale (this route has
        // none) and would silently only ever emit one language.
        foreach (self::STATIC_ROUTES as $name => [$changefreq, $priority]) {
            foreach ($locales as $locale) {
                $urls->push([
                    'loc' => route($name, ['locale' => $locale]),
                    'lastmod' => null,
                    'changefreq' => $changefreq,
                    'priority' => $priority,
                ]);
            }
        }

        $collections = [
            [BlogPost::published()->get(), 'blog.show', 'post', 'monthly', '0.7'],
            [Project::published()->get(), 'projects.show', 'project', 'yearly', '0.6'],
            [System::published()->get(), 'systems.show', 'system', 'yearly', '0.6'],
        ];

        foreach ($collections as [$models, $routeName, $param, $changefreq, $priority]) {
            foreach ($models as $model) {
                foreach ($locales as $locale) {
                    if (! $model->hasLocale($locale)) {
                        continue;
                    }

                    $urls->push([
                        'loc' => route($routeName, ['locale' => $locale, $param => $model->{"slug_{$locale}"}]),
                        'lastmod' => $model->updated_at?->toAtomString(),
                        'changefreq' => $changefreq,
                        'priority' => $priority,
                    ]);
                }
            }
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
