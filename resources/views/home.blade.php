@extends('layouts.app')

@section('seo')
    <x-seo page="home" />
@endsection

@push('schema')
    <x-schema.local-business />
@endpush

@section('content')

{{-- Hero ------------------------------------------------------------------ --}}
<section class="relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16 md:pt-28 md:pb-24">
        <div class="text-center max-w-4xl mx-auto">
            <p class="glass-pill inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-sm text-blue-800">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                {{ __('home.hero.eyebrow') }}
            </p>

            {{-- Each fragment is inline-block so a phrase never splits across
                 two lines — the break lands between fragments, not inside one. --}}
            <h1 class="mt-6 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 text-balance">
                <span class="inline-block">{{ __('home.hero.title_lead') }}</span>
                <span class="inline-block text-blue-700">{{ __('home.hero.title_accent') }}</span>
                <span class="block mt-1">{{ __('home.hero.title_tail') }}</span>
            </h1>

            <p class="mt-6 text-lg md:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                {{ __('home.hero.subtitle') }}
            </p>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('systems.index') }}" class="glass-btn-primary w-full sm:w-auto px-7 py-3.5 rounded-full font-semibold">
                    {{ __('home.hero.cta_primary') }}
                </a>
                <a href="{{ route('contact') }}" class="glass-btn w-full sm:w-auto px-7 py-3.5 rounded-full font-semibold text-slate-800">
                    {{ __('home.hero.cta_secondary') }}
                </a>
            </div>
        </div>

        {{-- Trust strip --}}
        <div class="mt-16 glass rounded-3xl p-6 md:p-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                @foreach(__('home.trust.items') as $stat)
                    <div>
                        <div class="text-2xl md:text-3xl font-extrabold text-slate-900">{{ $stat['value'] }}</div>
                        <div class="mt-1 text-sm text-slate-600 leading-snug">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
            <p class="mt-6 pt-5 border-t border-white/60 text-center text-sm text-slate-500">
                {{ __('home.trust.note') }}
            </p>
        </div>
    </div>
</section>

{{-- Partners of success --------------------------------------------------- --}}
@if($clients->isNotEmpty())
<section class="pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('clients.strip_title') }}</p>
        <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($clients->take(12) as $client)
                <x-client-logo :client="$client" class="h-20" />
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('clients.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-800">
                {{ __('clients.eyebrow') }}
                <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

{{-- Problem, in the customer's own words ---------------------------------- --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('home.problem.eyebrow') }}</p>
            <h2 class="mt-2 text-3xl md:text-4xl font-bold text-slate-900">{{ __('home.problem.title') }}</h2>
            <p class="mt-3 text-slate-600">{{ __('home.problem.subtitle') }}</p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach(__('home.problem.items') as $item)
                <div class="glass-card rounded-3xl p-6">
                    <p class="text-lg font-bold text-slate-900 leading-snug">&ldquo;{{ $item['quote'] }}&rdquo;</p>
                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $item['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- The five products ----------------------------------------------------- --}}
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('home.solution.eyebrow') }}</p>
            <h2 class="mt-2 text-3xl md:text-4xl font-bold text-slate-900">{{ __('home.solution.title') }}</h2>
            <p class="mt-3 text-slate-600">{{ __('home.solution.subtitle') }}</p>
        </div>

        @php
            // Index-matched to home.solution.items: the copy stays in the
            // language files, only the icon path lives here.
            $icons = [
                'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.46 12C3.73 7.94 7.52 5 12 5s8.27 2.94 9.54 7c-1.27 4.06-5.06 7-9.54 7s-8.27-2.94-9.54-7z',
                'M9 14l6-6M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6z',
                'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                'M9 17v-6h12M9 17H4V5a2 2 0 012-2h9l4 4v4M9 17l-2 3h12l-2-3',
                'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            ];
        @endphp

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach(__('home.solution.items') as $i => $item)
                <div class="glass-card rounded-3xl p-6">
                    <div class="glass-subtle w-12 h-12 rounded-2xl flex items-center justify-center text-blue-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$i] ?? $icons[0] }}"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-bold text-slate-900">{{ $item['name'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $item['body'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('systems.index') }}" class="glass-btn inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-slate-800">
                {{ __('nav.products') }}
                <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- Featured work --------------------------------------------------------- --}}
@if($featuredProjects->isNotEmpty())
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('home.work.eyebrow') }}</p>
            <h2 class="mt-2 text-3xl md:text-4xl font-bold text-slate-900">{{ __('home.work.title') }}</h2>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($featuredProjects as $project)
                <a href="{{ route('projects.show', $project) }}" class="glass-card rounded-3xl overflow-hidden block">
                    @if($project->image)
                        <div class="aspect-video bg-white/40 overflow-hidden">
                            <img src="{{ Storage::disk('public')->url($project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="font-bold text-slate-900">{{ $project->title }}</h3>
                        <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $project->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('projects.index') }}" class="glass-btn inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-slate-800">
                {{ __('home.work.cta') }}
                <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

{{-- Latest posts ---------------------------------------------------------- --}}
@if($latestPosts->isNotEmpty())
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('home.blog.eyebrow') }}</p>
            <h2 class="mt-2 text-3xl md:text-4xl font-bold text-slate-900">{{ __('home.blog.title') }}</h2>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($latestPosts as $post)
                <a href="{{ route('blog.show', $post) }}" class="glass-card rounded-3xl p-6 block">
                    <time class="text-xs text-slate-500" datetime="{{ $post->published_at?->toDateString() }}">
                        {{ $post->published_at?->translatedFormat('j F Y') }}
                    </time>
                    <h3 class="mt-2 font-bold text-slate-900 leading-snug">{{ $post->title }}</h3>
                    @if($post->excerpt)
                        <p class="mt-2 text-sm text-slate-600 line-clamp-3">{{ $post->excerpt }}</p>
                    @endif
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('blog.index') }}" class="glass-btn inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-slate-800">
                {{ __('home.blog.cta') }}
                <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

{{-- Closing CTA ----------------------------------------------------------- --}}
<section class="pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-strong rounded-3xl p-10 md:p-14 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900">{{ __('home.cta.title') }}</h2>
            <p class="mt-4 text-slate-600 max-w-xl mx-auto leading-relaxed">{{ __('home.cta.body') }}</p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('contact') }}" class="glass-btn-primary w-full sm:w-auto px-7 py-3.5 rounded-full font-semibold">
                    {{ __('home.cta.button') }}
                </a>
                <a href="{{ route('systems.index') }}" class="glass-btn w-full sm:w-auto px-7 py-3.5 rounded-full font-semibold text-slate-800">
                    {{ __('home.cta.secondary') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
