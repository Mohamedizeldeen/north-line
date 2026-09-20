@props(['items' => []])

@php
    // $items: [['question' => '...', 'answer' => '...'], ...]
    // Every Q&A here MUST also be visible on the page — FAQPage markup for
    // content a visitor cannot see is a structured-data violation.
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($items)->map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $item['answer'],
            ],
        ])->values()->all(),
    ];
@endphp

@if(filled($items))
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endif
