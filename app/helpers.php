<?php

use App\Models\Concerns\HasLocale;
use Illuminate\Database\Eloquent\Model;
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

if (! function_exists('localized_alternate')) {
    /**
     * URL of the EXACT equivalent of this page in another locale, or null when
     * there is no equivalent.
     *
     * Null is the important case. A detail page's slug differs per language
     * (/ar/blog/تكلفة-متجر vs /en/blog/store-cost), so the locale segment cannot
     * simply be swapped — the counterpart is found through the translation
     * group. When an article has not been written in the other language,
     * hreflang must stay silent rather than point at a page that is not the
     * translation.
     */
    function localized_alternate(string $locale): ?string
    {
        $route = request()->route();

        // SetLocale removes the {locale} parameter after reading it, so the
        // route's URI — not its parameters — is what identifies a localized page.
        if (! $route || ! $route->getName() || ! str_starts_with($route->uri(), '{locale}')) {
            return null;
        }

        $parameters = ['locale' => $locale];

        foreach ($route->parameters() as $key => $value) {
            if ($key === 'locale') {
                continue;
            }

            if ($value instanceof Model && in_array(HasLocale::class, class_uses_recursive($value), true)) {
                $translation = $value->translation($locale);

                if (! $translation) {
                    return null;
                }

                $parameters[$key] = $translation;

                continue;
            }

            $parameters[$key] = $value;
        }

        $url = route($route->getName(), $parameters);

        // Keep the reader on the same page of a listing.
        $page = request()->integer('page');

        return $page > 1 ? $url.'?page='.$page : $url;
    }
}

if (! function_exists('localized_url')) {
    /**
     * Where the language switcher should send the reader.
     *
     * Unlike localized_alternate() this always returns something: if the exact
     * page does not exist in the other language, fall back to that language's
     * homepage rather than a dead link.
     */
    function localized_url(string $locale): string
    {
        return localized_alternate($locale) ?? route('home', ['locale' => $locale]);
    }
}

if (! function_exists('video_embed_url')) {
    /**
     * Convert a YouTube/Vimeo watch URL to its embeddable player URL.
     *
     * Returns null for anything it does not recognise — the caller then treats
     * the URL as a direct video file for a native <video> element instead.
     */
    function video_embed_url(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
            return 'https://www.youtube.com/embed/'.$m[1];
        }

        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
            return 'https://player.vimeo.com/video/'.$m[1];
        }

        return null;
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
