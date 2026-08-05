<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the active locale from the {locale} route segment and makes every
 * generated URL carry it.
 *
 * URL::defaults() is the important part: it means route('blog.index') keeps
 * working untouched everywhere and automatically emits /ar/blog or /en/blog to
 * match the page being rendered. Routes outside the locale group (admin, login,
 * the sitemap) still generate valid localized links because this runs on the
 * whole web group and falls back to the default locale.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! is_string($locale) || ! array_key_exists($locale, config('site.locales'))) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
