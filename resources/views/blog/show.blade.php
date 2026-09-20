@extends('layouts.app')

@section('seo')
    <x-seo :title="$post->title"
           :description="meta_description($post->excerpt, $post->content)"
           :image="$post->featured_image"
           type="article"
           :published-at="$post->published_at"
           :modified-at="$post->updated_at" />
@endsection

@push('schema')
    <x-schema.blog-posting :post="$post" />
    <x-schema.breadcrumbs :items="[
        ['name' => __('nav.blog'), 'url' => route('blog.index')],
        ['name' => $post->title, 'url' => route('blog.show', $post)],
    ]" />
@endpush

@section('content')

<article>
    <section class="pt-12 pb-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-700 transition">
                <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5 5-5M18 12H6"/></svg>
                {{ __('blog.back') }}
            </a>

            <h1 class="mt-4 text-3xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ $post->title }}</h1>

            <div class="mt-5 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-slate-500">
                @if($post->author)
                    <span>{{ __('blog.by') }} {{ $post->author->name }}</span>
                    <span aria-hidden="true">&middot;</span>
                @endif
                <time datetime="{{ $post->published_at?->toDateString() }}">
                    {{ $post->published_at?->translatedFormat('j F Y') }}
                </time>
                {{-- Freshness is weighted heavily by AI search engines. --}}
                @if($post->updated_at && $post->published_at && $post->updated_at->gt($post->published_at->addDay()))
                    <span aria-hidden="true">&middot;</span>
                    <span>{{ __('blog.updated') }}: <time datetime="{{ $post->updated_at->toDateString() }}">{{ $post->updated_at->translatedFormat('j F Y') }}</time></span>
                @endif
            </div>
        </div>
    </section>

    @if($post->featured_image)
        <section class="pb-8">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="reveal glass rounded-3xl overflow-hidden p-2">
                    <img src="{{ Storage::disk('public')->url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full rounded-2xl">
                </div>
            </div>
        </section>
    @endif

    <section class="pb-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal glass rounded-3xl p-7 md:p-10">
                <div class="prose prose-slate prose-lg max-w-none">
                    {!! Str::markdown($post->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                </div>
            </div>
        </div>
    </section>
</article>

@if($relatedPosts->isNotEmpty())
    <section class="pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="reveal text-2xl font-bold text-slate-900">{{ __('blog.related') }}</h2>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($relatedPosts as $related)
                    <a href="{{ route('blog.show', $related) }}" class="reveal glass-card rounded-3xl p-6 block" style="--reveal-delay: {{ $loop->index * 90 }}ms">
                        <time class="text-xs text-slate-500" datetime="{{ $related->published_at?->toDateString() }}">
                            {{ $related->published_at?->translatedFormat('j F Y') }}
                        </time>
                        <h3 class="mt-2 font-bold text-slate-900 leading-snug">{{ $related->title }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal glass-strong rounded-3xl p-10 md:p-14 text-center">
            <h2 class="text-3xl font-bold text-slate-900">{{ __('blog.cta.title') }}</h2>
            <p class="mt-4 text-slate-600 max-w-xl mx-auto leading-relaxed">{{ __('blog.cta.body') }}</p>
            <a href="{{ route('contact') }}" class="glass-btn-primary inline-block mt-8 px-7 py-3.5 rounded-full font-semibold">
                {{ __('blog.cta.button') }}
            </a>
        </div>
    </div>
</section>

@endsection
