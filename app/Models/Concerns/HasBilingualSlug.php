<?php

namespace App\Models\Concerns;

/**
 * Content that carries both languages on one row (title_ar/title_en,
 * slug_ar/slug_en, ...), with a slug that resolves against whichever
 * language the current URL is in.
 *
 * Route generation and binding both key off the {locale} route segment:
 * - Inside a public request (SetLocale leaves {locale} readable before it
 *   forgets the parameter), the URL for this model is its slug in that
 *   locale, and an incoming slug is looked up in that same locale.
 * - Outside a localized route (admin, console), both fall back to id, so
 *   the admin panel can reach a row regardless of which languages it has.
 *
 * Generating a link to a DIFFERENT locale than the current request (hreflang
 * alternates, the sitemap) must not rely on this — pass the target locale's
 * slug_{locale} explicitly instead, since request()->route('locale') only
 * ever reflects the request being served right now.
 */
trait HasBilingualSlug
{
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function getRouteKey()
    {
        if ($locale = request()->route('locale')) {
            return $this->{"slug_{$locale}"} ?? $this->id;
        }

        return $this->id;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($locale = request()->route('locale')) {
            return static::where("slug_{$locale}", $value)->firstOrFail();
        }

        return static::where('id', $value)->firstOrFail();
    }

    /** Locales this row has content in. */
    public function availableLocales(): array
    {
        return collect(array_keys(config('site.locales')))
            ->filter(fn ($locale) => ! is_null($this->{"slug_{$locale}"}))
            ->values()
            ->all();
    }

    public function hasLocale(string $locale): bool
    {
        return ! is_null($this->{"slug_{$locale}"});
    }

    /** Rows that have content in the given locale (defaults to the active one). */
    public function scopeAvailableIn($query, ?string $locale = null)
    {
        return $query->whereNotNull('slug_'.($locale ?? app()->getLocale()));
    }
}
