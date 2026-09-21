<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')->latest()->paginate(15);

        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog-posts.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $attrs = $this->sharedAttributes($request, null);
        $attrs['is_published'] = $request->boolean('is_published');
        $attrs['published_at'] = $this->publishedAt($attrs['is_published'], null);

        BlogPost::create(array_merge($attrs, $this->localizedAttributes($validated)));

        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog-posts.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $this->validated($request);
        $attrs = $this->sharedAttributes($request, $blogPost);
        $attrs['is_published'] = $request->boolean('is_published');
        $attrs['published_at'] = $this->publishedAt($attrs['is_published'], $blogPost);

        $blogPost->update(array_merge($attrs, $this->localizedAttributes($validated)));

        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post deleted successfully.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'excerpt_ar' => 'nullable|string|max:500',
            'excerpt_en' => 'nullable|string|max:500',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
            'remove_featured_image' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $validated += [
            'title_ar' => null, 'title_en' => null,
            'excerpt_ar' => null, 'excerpt_en' => null,
            'content_ar' => null, 'content_en' => null,
        ];

        if (! $validated['title_ar'] && ! $validated['title_en']) {
            throw ValidationException::withMessages(['title_ar' => 'Provide a title in at least one language.']);
        }

        if ($validated['title_ar'] && ! $validated['content_ar']) {
            throw ValidationException::withMessages(['content_ar' => 'Arabic content is required when the Arabic title is set.']);
        }

        if ($validated['title_en'] && ! $validated['content_en']) {
            throw ValidationException::withMessages(['content_en' => 'English content is required when the English title is set.']);
        }

        return $validated;
    }

    /** Title/slug/excerpt/content, per language, cleared when that language's title is blank. */
    private function localizedAttributes(array $validated): array
    {
        return [
            'title_ar' => $validated['title_ar'],
            'slug_ar' => $validated['title_ar'] ? Str::slug($validated['title_ar']) : null,
            'excerpt_ar' => $validated['title_ar'] ? $validated['excerpt_ar'] : null,
            'content_ar' => $validated['title_ar'] ? $validated['content_ar'] : null,
            'title_en' => $validated['title_en'],
            'slug_en' => $validated['title_en'] ? Str::slug($validated['title_en']) : null,
            'excerpt_en' => $validated['title_en'] ? $validated['excerpt_en'] : null,
            'content_en' => $validated['title_en'] ? $validated['content_en'] : null,
        ];
    }

    /** Fields that are not language-specific. */
    private function sharedAttributes(Request $request, ?BlogPost $existing): array
    {
        $shared = [
            'user_id' => auth()->id(),
        ];

        if ($request->boolean('remove_featured_image')) {
            if ($existing?->featured_image) {
                Storage::disk('public')->delete($existing->featured_image);
            }
            $shared['featured_image'] = null;
        } elseif ($request->hasFile('featured_image')) {
            if ($existing?->featured_image) {
                Storage::disk('public')->delete($existing->featured_image);
            }
            $shared['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        return $shared;
    }

    private function publishedAt(bool $publish, ?BlogPost $existing): ?\Illuminate\Support\Carbon
    {
        if (! $publish) {
            return null;
        }

        return $existing?->published_at ?? now();
    }
}
