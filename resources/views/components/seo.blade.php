@props([
    // Key group in lang/{locale}/seo.php — e.g. page="home" reads seo.home.title
    'page' => null,
    // Explicit overrides, for dynamic pages (blog posts, projects, systems)
    'title' => null,
    'description' => null,
    'image' => null,
    'canonical' => null,
    'type' => 'website',
    'noindex' => false,
    'publishedAt' => null,
    'modifiedAt' => null,
])

@php
    $locale = app()->getLocale();
    $locales = config('site.locales');

    $resolvedTitle = $title
        ?? ($page ? __("seo.{$page}.title") : null)
        ?? __('seo.defaults.title');

    // Brand suffix only when it still fits inside the 60-character budget.
    $suffix = __('seo.suffix');
    if ($page === null && mb_strlen($resolvedTitle . $suffix) <= 60) {
        $resolvedTitle .= $suffix;
    }
    $resolvedTitle = mb_strlen($resolvedTitle) > 60
        ? rtrim(mb_substr($resolvedTitle, 0, 59)) . '…'
        : $resolvedTitle;

    $resolvedDescription = trim(preg_replace('/\s+/u', ' ', (string) (
        $description
        ?? ($page ? __("seo.{$page}.description") : null)
        ?? __('seo.defaults.description')
    )));
    if (mb_strlen($resolvedDescription) > 160) {
        $resolvedDescription = rtrim(mb_substr($resolvedDescription, 0, 159), " \t\n\r\0\x0B.,،") . '…';
    }

    // Self-referencing canonical. Never points at another language — a
    // cross-language canonical de-indexes the non-canonical version entirely.
    $page_ = request()->integer('page');
    $resolvedCanonical = $canonical
        ?? url()->current() . ($page_ > 1 ? '?page=' . $page_ : '');

    // og:image must be absolute. The `public` disk is named explicitly because
    // the default disk (`local`) yields a relative /storage/... path.
    $resolvedImage = $image
        ? (Str::startsWith($image, ['http://', 'https://']) ? $image : Storage::disk('public')->url($image))
        : asset(config('site.og_image'));
@endphp

<title>{{ $resolvedTitle }}</title>
<meta name="description" content="{{ $resolvedDescription }}">
<link rel="canonical" href="{{ $resolvedCanonical }}">

@if($noindex)
    <meta name="robots" content="noindex, follow">
@else
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
@endif

{{--
    hreflang. Emitted only once a second locale exists (PHASE 3), because a
    lone self-referencing alternate carries no signal. Every page lists every
    locale INCLUDING itself, which is what makes the set reciprocal — if ar
    points to en but en does not point back, Google discards both.
--}}
@if(count($locales) > 1)
    @foreach($locales as $code => $meta)
        <link rel="alternate" hreflang="{{ $meta['hreflang'] }}" href="{{ localized_url($code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ localized_url(config('site.x_default_locale')) }}">
@endif

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ config('site.legal_name') }}">
<meta property="og:title" content="{{ $resolvedTitle }}">
<meta property="og:description" content="{{ $resolvedDescription }}">
<meta property="og:url" content="{{ $resolvedCanonical }}">
<meta property="og:image" content="{{ $resolvedImage }}">
<meta property="og:locale" content="{{ $locales[$locale]['hreflang'] ?? $locale }}">
@foreach($locales as $code => $meta)
    @if($code !== $locale)
        <meta property="og:locale:alternate" content="{{ $meta['hreflang'] }}">
    @endif
@endforeach
@if($type === 'article')
    @if($publishedAt)<meta property="article:published_time" content="{{ $publishedAt->toIso8601String() }}">@endif
    @if($modifiedAt)<meta property="article:modified_time" content="{{ $modifiedAt->toIso8601String() }}">@endif
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $resolvedTitle }}">
<meta name="twitter:description" content="{{ $resolvedDescription }}">
<meta name="twitter:image" content="{{ $resolvedImage }}">
