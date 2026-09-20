@props(['post'])

@php
    $schema = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting',
        '@id' => url()->current() . '#article',
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
        'headline' => Str::limit($post->title, 110, ''),
        'description' => $post->excerpt ?: Str::limit(strip_tags($post->content), 160),
        'image' => $post->featured_image
            ? Storage::disk('public')->url($post->featured_image)
            : asset(config('site.og_image')),
        'datePublished' => $post->published_at?->toIso8601String(),
        'dateModified' => ($post->updated_at ?? $post->published_at)?->toIso8601String(),
        'inLanguage' => app()->getLocale(),
        'author' => $post->author ? [
            '@type' => 'Person',
            'name' => $post->author->name,
        ] : ['@id' => url('/') . '/#organization'],
        'publisher' => ['@id' => url('/') . '/#organization'],
    ]);
@endphp

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
