<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SystemController extends Controller
{
    public function index(Request $request)
    {
        $systems = System::when($request->filled('locale'), fn ($q) => $q->where('locale', $request->string('locale')))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.systems.index', compact('systems'));
    }

    public function create()
    {
        return view('admin.systems.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePair($request);
        $shared = $this->sharedAttributes($request, $validated, null);

        $this->savePair($validated, $shared, null, null);

        return redirect()->route('admin.systems.index')->with('success', 'System created successfully.');
    }

    public function edit(System $system)
    {
        [$ar, $en] = $this->pair($system);

        return view('admin.systems.edit', compact('system', 'ar', 'en'));
    }

    public function update(Request $request, System $system)
    {
        $validated = $this->validatePair($request);

        [$ar, $en] = $this->pair($system);

        $shared = $this->sharedAttributes($request, $validated, $ar ?? $en);

        $this->savePair($validated, $shared, $ar, $en);

        return redirect()->route('admin.systems.index')->with('success', 'System updated successfully.');
    }

    public function destroy(System $system)
    {
        $system->delete();

        return redirect()->route('admin.systems.index')->with('success', 'System deleted successfully.');
    }

    /** The Arabic and English rows of the same system, if they exist. */
    private function pair(System $system): array
    {
        $sibling = $system->translation($system->locale === 'ar' ? 'en' : 'ar');

        return [
            $system->locale === 'ar' ? $system : $sibling,
            $system->locale === 'en' ? $system : $sibling,
        ];
    }

    private function validatePair(Request $request): array
    {
        $validated = $request->validate([
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'remove_image' => 'boolean',
            'video_url' => 'nullable|url|max:255',
            'video_path' => 'nullable|mimetypes:video/mp4,video/webm|max:51200',
            'remove_video' => 'boolean',
            'demo_url' => 'nullable|url|max:255',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated += [
            'title_ar' => null, 'title_en' => null,
            'description_ar' => null, 'description_en' => null,
            'content_ar' => null, 'content_en' => null,
        ];

        if (! $validated['title_ar'] && ! $validated['title_en']) {
            throw ValidationException::withMessages(['title_ar' => 'Provide a title in at least one language.']);
        }

        if ($validated['title_ar'] && ! $validated['description_ar']) {
            throw ValidationException::withMessages(['description_ar' => 'Arabic description is required when the Arabic title is set.']);
        }

        if ($validated['title_en'] && ! $validated['description_en']) {
            throw ValidationException::withMessages(['description_en' => 'English description is required when the English title is set.']);
        }

        return $validated;
    }

    /** Fields that are not language-specific: one value shared by both rows. */
    private function sharedAttributes(Request $request, array $validated, ?System $existing): array
    {
        $shared = [
            'demo_url' => $validated['demo_url'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->boolean('remove_image')) {
            if ($existing?->image) {
                Storage::disk('public')->delete($existing->image);
            }
            $shared['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($existing?->image) {
                Storage::disk('public')->delete($existing->image);
            }
            $shared['image'] = $request->file('image')->store('systems', 'public');
        }

        if ($request->boolean('remove_video')) {
            if ($existing?->video_path) {
                Storage::disk('public')->delete($existing->video_path);
            }
            $shared['video_path'] = null;
            $shared['video_url'] = null;
        } elseif ($request->hasFile('video_path')) {
            if ($existing?->video_path) {
                Storage::disk('public')->delete($existing->video_path);
            }
            $shared['video_path'] = $request->file('video_path')->store('systems', 'public');
        }

        return $shared;
    }

    private function savePair(array $validated, array $shared, ?System $ar, ?System $en): void
    {
        if ($validated['title_ar']) {
            $attrs = array_merge($shared, [
                'title' => $validated['title_ar'],
                'slug' => Str::slug($validated['title_ar']),
                'description' => $validated['description_ar'],
                'content' => $validated['content_ar'] ?? null,
            ]);

            $ar = $ar ? tap($ar)->update($attrs) : System::create(array_merge($attrs, ['locale' => 'ar']));
        }

        if ($validated['title_en']) {
            $attrs = array_merge($shared, [
                'title' => $validated['title_en'],
                'slug' => Str::slug($validated['title_en']),
                'description' => $validated['description_en'],
                'content' => $validated['content_en'] ?? null,
            ]);

            $en = $en ? tap($en)->update($attrs) : System::create(array_merge($attrs, ['locale' => 'en']));
        }

        if ($ar && $en) {
            $ar->pairWith($en);
        }
    }
}
