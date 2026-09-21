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
    public function index()
    {
        $systems = System::orderBy('sort_order')->latest()->paginate(15);

        return view('admin.systems.index', compact('systems'));
    }

    public function create()
    {
        return view('admin.systems.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $attrs = $this->sharedAttributes($request, $validated, null);

        System::create(array_merge($attrs, $this->localizedAttributes($validated)));

        return redirect()->route('admin.systems.index')->with('success', 'System created successfully.');
    }

    public function edit(System $system)
    {
        return view('admin.systems.edit', compact('system'));
    }

    public function update(Request $request, System $system)
    {
        $validated = $this->validated($request);
        $attrs = $this->sharedAttributes($request, $validated, $system);

        $system->update(array_merge($attrs, $this->localizedAttributes($validated)));

        return redirect()->route('admin.systems.index')->with('success', 'System updated successfully.');
    }

    public function destroy(System $system)
    {
        $system->delete();

        return redirect()->route('admin.systems.index')->with('success', 'System deleted successfully.');
    }

    private function validated(Request $request): array
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

    /** Title/slug/description/content, per language, cleared when that language's title is blank. */
    private function localizedAttributes(array $validated): array
    {
        return [
            'title_ar' => $validated['title_ar'],
            'slug_ar' => $validated['title_ar'] ? Str::slug($validated['title_ar']) : null,
            'description_ar' => $validated['title_ar'] ? $validated['description_ar'] : null,
            'content_ar' => $validated['title_ar'] ? $validated['content_ar'] : null,
            'title_en' => $validated['title_en'],
            'slug_en' => $validated['title_en'] ? Str::slug($validated['title_en']) : null,
            'description_en' => $validated['title_en'] ? $validated['description_en'] : null,
            'content_en' => $validated['title_en'] ? $validated['content_en'] : null,
        ];
    }

    /** Fields that are not language-specific. */
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
}
