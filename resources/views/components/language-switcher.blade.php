@php
    $current = app()->getLocale();
    // Two locales, so the switcher is a direct toggle to the other one rather
    // than a dropdown. It links to the SAME page in the other language, which
    // is also what makes the hreflang pair reciprocal.
    $target = collect(config('site.locales'))->keys()->first(fn ($code) => $code !== $current);
@endphp

@if($target)
    <a href="{{ localized_url($target) }}"
       hreflang="{{ config("site.locales.{$target}.hreflang") }}"
       lang="{{ $target }}"
       dir="{{ config("site.locales.{$target}.dir") }}"
       rel="alternate"
       class="glass-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium text-slate-700"
       aria-label="{{ config("site.locales.{$target}.name") }}">
        <svg class="w-4 h-4 opacity-60" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="12" cy="12" r="9"/>
            <path d="M3.6 9h16.8M3.6 15h16.8" stroke-linecap="round"/>
            <path d="M12 3a15 15 0 0 1 0 18a15 15 0 0 1 0-18z"/>
        </svg>
        {{ config("site.locales.{$target}.name") }}
    </a>
@endif
