@extends('layouts.app')
@section('title', 'Blog')
@section('meta_description', 'Read the latest insights, tutorials, and updates from North Line Development.')

@section('content')
{{-- 1. Header Section --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Our Blog</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Blog</h1>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">Insights, tutorials, and updates from our team.</p>
        </div>
    </div>
</section>

{{-- 2. Blog Posts Grid --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-300 transition">
                        @if($post->featured_image)
                            <div class="aspect-video bg-gray-100 overflow-hidden">
                                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                        @else
                            <div class="aspect-video bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div class="p-5">
                            <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                @if($post->author)
                                    <span>&middot;</span>
                                    <span>{{ $post->author->name }}</span>
                                @endif
                            </div>
                            <h2 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition">{{ $post->title }}</h2>
                            @if($post->excerpt)
                                <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $post->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">{{ $posts->links() }}</div>
        @else
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <h2 class="text-xl font-bold text-gray-400">No blog posts yet</h2>
                <p class="text-gray-500 mt-2">Check back soon for new content!</p>
            </div>
        @endif
    </div>
</section>

{{-- 3. Topics We Cover --}}
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Topics We Cover</h2>
            <p class="text-gray-500 mt-2">Explore our content across different areas of web development.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5 text-center hover:shadow-md transition">
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 text-sm">Development</h3>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 text-center hover:shadow-md transition">
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 text-sm">Design</h3>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 text-center hover:shadow-md transition">
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 text-sm">Business</h3>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 text-center hover:shadow-md transition">
                <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 text-sm">Tutorials</h3>
            </div>
        </div>
    </div>
</section>

{{-- 4. Newsletter CTA --}}
<section class="py-16 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl p-10">
            <h2 class="text-2xl md:text-3xl font-bold text-white">Stay Updated</h2>
            <p class="text-blue-100 mt-3 max-w-md mx-auto">Follow our blog for the latest insights on web development, technology trends, and business solutions.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 px-6 py-3 rounded-xl font-semibold transition mt-6">
                Get in Touch
            </a>
        </div>
    </div>
</section>
@endsection
