@extends('layouts.app')

@section('seo')
    <x-seo page="blog" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[['name' => __('nav.blog'), 'url' => route('blog.index')]]" />
@endpush

@section('content')

<section class="pt-20 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('blog.eyebrow') }}</p>
        <h1 class="mt-2 text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ __('blog.title') }}</h1>
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ __('blog.subtitle') }}</p>
    </div>
</section>

<section class="pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="glass-card rounded-3xl overflow-hidden block">
                        @if($post->featured_image)
                            <div class="aspect-video bg-white/40 overflow-hidden">
                                <img src="{{ Storage::disk('public')->url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('j F Y') }}</time>
                                @if($post->author)
                                    <span aria-hidden="true">&middot;</span>
                                    <span>{{ $post->author->name }}</span>
                                @endif
                            </div>
                            <h2 class="mt-2 text-lg font-bold text-slate-900 leading-snug">{{ $post->title }}</h2>
                            @if($post->excerpt)
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed line-clamp-3">{{ $post->excerpt }}</p>
                            @endif
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700">
                                {{ __('blog.read_more') }}
                                <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">{{ $posts->links() }}</div>
        @else
            <div class="glass rounded-3xl p-12 text-center">
                <h2 class="text-xl font-bold text-slate-800">{{ __('blog.empty.title') }}</h2>
                <p class="mt-2 text-slate-600">{{ __('blog.empty.body') }}</p>
            </div>
        @endif
    </div>
</section>

<section class="pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-strong rounded-3xl p-10 md:p-14 text-center">
            <h2 class="text-3xl font-bold text-slate-900">{{ __('blog.cta.title') }}</h2>
            <p class="mt-4 text-slate-600 max-w-xl mx-auto leading-relaxed">{{ __('blog.cta.body') }}</p>
            <a href="{{ route('contact') }}" class="glass-btn-primary inline-block mt-8 px-7 py-3.5 rounded-full font-semibold">
                {{ __('blog.cta.button') }}
            </a>
        </div>
    </div>
</section>

@endsection
