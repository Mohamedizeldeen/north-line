<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $attrs = $this->sharedAttributes($request, $validated, null);

        Project::create(array_merge($attrs, $this->localizedAttributes($validated)));

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->validated($request);
        $attrs = $this->sharedAttributes($request, $validated, $project);

        $project->update(array_merge($attrs, $this->localizedAttributes($validated)));

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
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
            'client' => 'nullable|string|max:255',
            'live_url' => 'nullable|url|max:255',
            'technologies_used' => 'nullable|string',
            'is_featured' => 'boolean',
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
    private function sharedAttributes(Request $request, array $validated, ?Project $existing): array
    {
        $shared = [
            'client' => $validated['client'] ?? null,
            'live_url' => $validated['live_url'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'technologies_used' => isset($validated['technologies_used'])
                ? array_map('trim', explode(',', $validated['technologies_used']))
                : null,
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
            $shared['image'] = $request->file('image')->store('projects', 'public');
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
            $shared['video_path'] = $request->file('video_path')->store('projects', 'public');
        }

        return $shared;
    }
}
