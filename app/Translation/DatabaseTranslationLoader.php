<?php

namespace App\Translation;

use App\Models\Translation;
use Illuminate\Contracts\Translation\Loader;
use Illuminate\Support\Arr;

/**
 * Decorates the default file loader: file translations remain the source of
 * truth and the defaults, and any rows in the `translations` table overlay
 * them at runtime. This lets the admin edit page copy without touching the
 * `lang/**` files or any `__()` call. If the table is missing or a query
 * fails, the file values are returned unchanged.
 */
class DatabaseTranslationLoader implements Loader
{
    public function __construct(private Loader $files) {}

    public function load($locale, $group, $namespace = null)
    {
        $lines = $this->files->load($locale, $group, $namespace);

        // Only overlay the application's own (non-namespaced) translations.
        if ($namespace !== null && $namespace !== '*') {
            return $lines;
        }

        try {
            $overrides = Translation::overrides()["{$locale}.{$group}"] ?? [];
        } catch (\Throwable) {
            return $lines;
        }

        foreach ($overrides as $item => $value) {
            Arr::set($lines, $item, $value);
        }

        return $lines;
    }

    public function addNamespace($namespace, $hint)
    {
        $this->files->addNamespace($namespace, $hint);
    }

    public function addJsonPath($path)
    {
        $this->files->addJsonPath($path);
    }

    public function namespaces()
    {
        return $this->files->namespaces();
    }
}
