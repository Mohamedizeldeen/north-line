<?php

namespace App\Models\Concerns;

/**
 * Content that carries both languages on one row (title_ar/title_en,
 * slug_ar/slug_en, ...), with a slug that resolves against whichever
 * language the current URL is in.
 *
 * Route generation and binding both key off whether the current route is
 * localized (its URI starts with the {locale} segment):
 * - Inside a public request, the URL for this model is its slug in the
 *   active app locale, and an incoming slug is looked up in that locale.
 * - Outside a localized route (admin, console), both fall back to id, so
 *   the admin panel can reach a row regardless of which languages it has.
 *
 * getRouteKey() reads app()->getLocale() rather than the {locale} route
 * parameter directly: SetLocale sets the app locale early, but forgets the
 * {locale} route parameter before the controller runs (so it doesn't leak
 * into action arguments), and by the time a view is rendering links to OTHER
 * rows — looping a project index, for instance — that parameter is already
 * gone. The route's URI pattern survives, though, which is what identifies a
 * localized route here.
 *
 * resolveRouteBinding() still reads the {locale} route parameter directly:
 * it runs during SubstituteBindings, before SetLocale has forgotten it.
 *
 * Generating a link to a DIFFERENT locale than the current request (hreflang
 * alternates, the sitemap) must not rely on either — pass the target
 * locale's slug_{locale} explicitly instead.
 */
trait HasBilingualSlug
{
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function getRouteKey()
    {
        if ($this->onLocalizedRoute()) {
            return $this->{'slug_'.app()->getLocale()} ?? $this->id;
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

    private function onLocalizedRoute(): bool
    {
        $route = request()->route();

        return $route && str_starts_with($route->uri(), '{locale}');
    }
}
