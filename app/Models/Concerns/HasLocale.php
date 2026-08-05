<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Content that exists in one language and may have siblings in others.
 *
 * @property string $locale
 * @property int|null $translation_group_id
 *
 * @mixin Model
 */
trait HasLocale
{
    /** Rows in the given locale (defaults to the active one). */
    public function scopeInLocale(Builder $query, ?string $locale = null): Builder
    {
        return $query->where('locale', $locale ?? app()->getLocale());
    }

    /**
     * The same content in another language, or null when it has not been
     * written. Null matters: hreflang must not point at a page that is not
     * actually the equivalent.
     */
    public function translation(string $locale): ?Model
    {
        if ($locale === $this->locale) {
            return $this;
        }

        if (! $this->translation_group_id) {
            return null;
        }

        return static::query()
            ->where('translation_group_id', $this->translation_group_id)
            ->where('locale', $locale)
            ->first();
    }

    /**
     * Slugs are only unique within a language, so a slug alone can resolve to
     * the wrong document. Scope the lookup to the locale in the URL.
     *
     * Only when the route actually has one: the admin routes are not localized
     * and must be able to reach a row in any language.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $query = $this->where($field ?? $this->getRouteKeyName(), $value);

        if ($locale = request()->route('locale')) {
            $query->where('locale', $locale);
        }

        return $query->firstOrFail();
    }

    /** Locales this content has been written in. */
    public function availableLocales(): array
    {
        if (! $this->translation_group_id) {
            return [$this->locale];
        }

        return static::query()
            ->where('translation_group_id', $this->translation_group_id)
            ->pluck('locale')
            ->all();
    }
}
