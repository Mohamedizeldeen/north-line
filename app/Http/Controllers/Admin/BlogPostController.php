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
    public function index(Request $request)
    {
        $posts = BlogPost::with('author')
            ->when($request->filled('locale'), fn ($q) => $q->where('locale', $request->string('locale')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog-posts.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePair($request);
        $shared = $this->sharedAttributes($request, null);

        $this->savePair($request, $validated, $shared, null, null);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blogPost)
    {
        [$ar, $en] = $this->pair($blogPost);

        return view('admin.blog-posts.edit', compact('blogPost', 'ar', 'en'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $this->validatePair($request);

        [$ar, $en] = $this->pair($blogPost);

        $shared = $this->sharedAttributes($request, $ar ?? $en);

        $this->savePair($request, $validated, $shared, $ar, $en);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post deleted successfully.');
    }

    /** The Arabic and English rows of the same post, if they exist. */
    private function pair(BlogPost $blogPost): array
    {
        $sibling = $blogPost->translation($blogPost->locale === 'ar' ? 'en' : 'ar');

        return [
            $blogPost->locale === 'ar' ? $blogPost : $sibling,
            $blogPost->locale === 'en' ? $blogPost : $sibling,
        ];
    }

    private function validatePair(Request $request): array
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

    /** Fields that are not language-specific: one value shared by both rows. */
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

    private function savePair(Request $request, array $validated, array $shared, ?BlogPost $ar, ?BlogPost $en): void
    {
        $publish = $request->boolean('is_published');

        if ($validated['title_ar']) {
            $attrs = array_merge($shared, [
                'title' => $validated['title_ar'],
                'slug' => Str::slug($validated['title_ar']),
                'excerpt' => $validated['excerpt_ar'] ?? null,
                'content' => $validated['content_ar'],
                'is_published' => $publish,
                'published_at' => $this->publishedAt($publish, $ar),
            ]);

            $ar = $ar ? tap($ar)->update($attrs) : BlogPost::create(array_merge($attrs, ['locale' => 'ar']));
        }

        if ($validated['title_en']) {
            $attrs = array_merge($shared, [
                'title' => $validated['title_en'],
                'slug' => Str::slug($validated['title_en']),
                'excerpt' => $validated['excerpt_en'] ?? null,
                'content' => $validated['content_en'],
                'is_published' => $publish,
                'published_at' => $this->publishedAt($publish, $en),
            ]);

            $en = $en ? tap($en)->update($attrs) : BlogPost::create(array_merge($attrs, ['locale' => 'en']));
        }

        if ($ar && $en) {
            $ar->pairWith($en);
        }
    }

    private function publishedAt(bool $publish, ?BlogPost $existing): ?\Illuminate\Support\Carbon
    {
        if (! $publish) {
            return null;
        }

        return $existing?->published_at ?? now();
    }
}
