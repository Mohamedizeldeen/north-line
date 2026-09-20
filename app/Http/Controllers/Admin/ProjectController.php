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
    public function index(Request $request)
    {
        $projects = Project::when($request->filled('locale'), fn ($q) => $q->where('locale', $request->string('locale')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePair($request);
        $shared = $this->sharedAttributes($request, $validated, null);

        $this->savePair($validated, $shared, null, null);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        [$ar, $en] = $this->pair($project);

        return view('admin.projects.edit', compact('project', 'ar', 'en'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->validatePair($request);

        [$ar, $en] = $this->pair($project);

        $shared = $this->sharedAttributes($request, $validated, $ar ?? $en);

        $this->savePair($validated, $shared, $ar, $en);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    /** The Arabic and English rows of the same project, if they exist. */
    private function pair(Project $project): array
    {
        $sibling = $project->translation($project->locale === 'ar' ? 'en' : 'ar');

        return [
            $project->locale === 'ar' ? $project : $sibling,
            $project->locale === 'en' ? $project : $sibling,
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

    /** Fields that are not language-specific: one value shared by both rows. */
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

    private function savePair(array $validated, array $shared, ?Project $ar, ?Project $en): void
    {
        if ($validated['title_ar']) {
            $attrs = array_merge($shared, [
                'title' => $validated['title_ar'],
                'slug' => Str::slug($validated['title_ar']),
                'description' => $validated['description_ar'],
                'content' => $validated['content_ar'] ?? null,
            ]);

            $ar = $ar ? tap($ar)->update($attrs) : Project::create(array_merge($attrs, ['locale' => 'ar']));
        }

        if ($validated['title_en']) {
            $attrs = array_merge($shared, [
                'title' => $validated['title_en'],
                'slug' => Str::slug($validated['title_en']),
                'description' => $validated['description_en'],
                'content' => $validated['content_en'] ?? null,
            ]);

            $en = $en ? tap($en)->update($attrs) : Project::create(array_merge($attrs, ['locale' => 'en']));
        }

        if ($ar && $en) {
            $ar->pairWith($en);
        }
    }
}
