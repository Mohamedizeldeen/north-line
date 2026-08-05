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
{{-- 1. Article Header --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 py-12 md:py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('blog.index') }}" class="text-sm text-blue-600 hover:text-blue-700 transition mb-4 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Blog
        </a>
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight text-gray-900 mt-4">{{ $post->title }}</h1>
        <div class="flex items-center gap-3 mt-4 text-sm text-gray-500">
            @if($post->author)
                <span>By {{ $post->author->name }}</span>
                <span>&middot;</span>
            @endif
            <time>{{ $post->published_at->format('F d, Y') }}</time>
        </div>
    </div>
</section>

{{-- 2. Featured Image --}}
@if($post->featured_image)
<section class="pb-4">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl overflow-hidden shadow-lg">
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full">
        </div>
    </div>
</section>
@endif

{{-- 3. Article Content --}}
<article class="py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! Str::markdown($post->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
        </div>
    </div>
</article>

{{-- 4. Author Box & Share --}}
<section class="py-10 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-50 rounded-2xl p-6 md:p-8 flex flex-col sm:flex-row items-start gap-4">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0">
                {{ $post->author ? strtoupper(substr($post->author->name, 0, 1)) : 'N' }}
            </div>
            <div>
                <p class="text-sm text-gray-400">Written by</p>
                <h3 class="font-bold text-gray-900 text-lg">{{ $post->author ? $post->author->name : 'North Line Team' }}</h3>
                <p class="text-gray-500 text-sm mt-1">Published on {{ $post->published_at->format('F d, Y') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- 5. Related Posts --}}
@if($relatedPosts->isNotEmpty())
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">More Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedPosts as $related)
                <a href="{{ route('blog.show', $related) }}" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-300 transition">
                    @if($related->featured_image)
                        <div class="aspect-video bg-gray-100 overflow-hidden">
                            <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    @endif
                    <div class="p-5">
                        <div class="text-xs text-gray-400 mb-2">{{ $related->published_at->format('M d, Y') }}</div>
                        <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $related->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
