<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ContentController extends Controller
{
    /** Editable content groups (lang file basenames). */
    private const GROUPS = ['home', 'nav', 'seo', 'products', 'work', 'blog', 'clients', 'quote', 'contact'];

    private const LOCALES = ['ar', 'en'];

    public function index()
    {
        return view('admin.content.index', [
            'groups' => self::GROUPS,
            'locales' => self::LOCALES,
        ]);
    }

    public function edit(string $lang, string $group)
    {
        $locale = $lang;
        abort_unless(in_array($locale, self::LOCALES, true) && in_array($group, self::GROUPS, true), 404);

        $items = $this->items($locale, $group);

        return view('admin.content.edit', compact('locale', 'group', 'items'));
    }

    public function update(Request $request, string $lang, string $group)
    {
        $locale = $lang;
        abort_unless(in_array($locale, self::LOCALES, true) && in_array($group, self::GROUPS, true), 404);

        $defaults = $this->fileDefaults($locale, $group);
        $submitted = $request->input('items', []);

        foreach (array_keys($this->items($locale, $group)) as $key) {
            if (! array_key_exists($key, $submitted)) {
                continue;
            }

            $value = (string) $submitted[$key];
            $default = (string) ($defaults[$key] ?? '');

            if ($value === $default || $value === '') {
                // Back to the file default → drop the override to keep the table lean.
                Translation::where(compact('locale', 'group'))->where('item', $key)->delete();
            } else {
                Translation::updateOrCreate(
                    ['locale' => $locale, 'group' => $group, 'item' => $key],
                    ['value' => $value],
                );
            }
        }

        Translation::flush();

        return redirect()->route('admin.content.edit', [$locale, $group])->with('success', 'Content saved successfully.');
    }

    /** File defaults flattened to dotted keys, scalars only, minus FAQ items. */
    private function fileDefaults(string $locale, string $group): array
    {
        $path = base_path("lang/{$locale}/{$group}.php");

        if (! is_file($path)) {
            return [];
        }

        $flat = Arr::dot(require $path);

        return collect($flat)
            ->reject(fn ($v, $k) => ! is_scalar($v) || ($group === 'contact' && str_starts_with($k, 'faqs.')))
            ->map(fn ($v) => (string) $v)
            ->all();
    }

    /** File defaults with any stored overrides applied, in file order. */
    private function items(string $locale, string $group): array
    {
        $defaults = $this->fileDefaults($locale, $group);
        $overrides = Translation::overrides()["{$locale}.{$group}"] ?? [];

        foreach ($defaults as $key => $default) {
            $defaults[$key] = $overrides[$key] ?? $default;
        }

        return $defaults;
    }
}
