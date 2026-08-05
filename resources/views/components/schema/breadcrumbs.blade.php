@props(['items' => []])

@php
    // $items: [['name' => 'Blog', 'url' => route('blog.index')], ...]
    // Home is prepended automatically; pass only the trail below it.
    $trail = collect([['name' => __('nav.home'), 'url' => route('home')]])
        ->concat($items)
        ->values();

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $trail->map(fn ($item, $i) => array_filter([
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => $item['url'] ?? null,
        ]))->all(),
    ];
@endphp

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
