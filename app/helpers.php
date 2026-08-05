<?php

use Illuminate\Support\Str;

if (! function_exists('meta_description')) {
    /**
     * Build a meta description in the 150-160 character band from real content.
     *
     * Prefers the hand-written summary (a post excerpt, a project description).
     * When that is too short to be a useful snippet, falls back to the body so
     * the tag carries substance — never pads with filler.
     */
    function meta_description(?string $preferred, ?string $fallback = null, int $min = 150, int $max = 160): string
    {
        $clean = fn (?string $v) => trim(preg_replace('/\s+/u', ' ', strip_tags((string) $v)));

        $preferred = $clean($preferred);

        if (mb_strlen($preferred) >= $min) {
            return Str::limit($preferred, $max - 1, '…');
        }

        $fallback = $clean($fallback);

        return mb_strlen($fallback) > mb_strlen($preferred)
            ? Str::limit($fallback, $max - 1, '…')
            : $preferred;
    }
}

if (! function_exists('localized_url')) {
    /**
     * URL of the current page in another locale, preserving the path and
     * route parameters. Used for hreflang alternates and the language
     * switcher.
     *
     * PHASE 2: only one locale is configured, so this returns the current URL.
     * PHASE 3 adds the /{locale} route prefix, at which point the route's
     * `locale` parameter is swapped and every consumer keeps working.
     */
    function localized_url(string $locale): string
    {
        $route = request()->route();

        // Pages outside the locale group (login, admin) have no counterpart —
        // send the switcher to that language's homepage rather than nowhere.
        if (! $route || ! $route->getName() || ! array_key_exists('locale', $route->parameters())) {
            return route('home', ['locale' => $locale]);
        }

        $url = route($route->getName(), ['locale' => $locale] + $route->parameters());

        // Preserve pagination so switching language does not drop you back to
        // page 1 of a listing.
        $page = request()->integer('page');

        return $page > 1 ? $url.'?page='.$page : $url;
    }
}

if (! function_exists('site_dir')) {
    /**
     * Text direction for the active locale — drives <html dir="...">.
     */
    function site_dir(?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        return config("site.locales.{$locale}.dir", 'ltr');
    }
}

if (! function_exists('is_rtl')) {
    function is_rtl(?string $locale = null): bool
    {
        return site_dir($locale) === 'rtl';
    }
}
