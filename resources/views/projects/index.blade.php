@extends('layouts.app')

@section('seo')
    <x-seo page="projects" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[['name' => __('nav.projects'), 'url' => route('projects.index')]]" />
@endpush

@section('content')
{{-- 1. Header Section --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Portfolio</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Software Projects Built in Muscat, Oman</h1>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">A showcase of our latest work and the solutions we've built for our clients.</p>
        </div>
    </div>
</section>

{{-- 2. Projects Grid --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($projects->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-300 transition">
                        @if($project->image)
                            <div class="aspect-video bg-gray-100 overflow-hidden">
                                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                        @else
                            <div class="aspect-video bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div class="p-5">
                            <h2 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition">{{ $project->title }}</h2>
                            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $project->description }}</p>
                            @if($project->technologies_used)
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    @foreach(array_slice($project->technologies_used, 0, 4) as $tech)
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                            @if($project->client)
                                <div class="text-xs text-gray-400 mt-3">Client: {{ $project->client }}</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">{{ $projects->links() }}</div>
        @else
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                <h2 class="text-xl font-bold text-gray-400">No projects yet</h2>
                <p class="text-gray-500 mt-2">We're working on exciting projects. Check back soon!</p>
            </div>
        @endif
    </div>
</section>

{{-- 3. Our Expertise --}}
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">What We Build</h2>
            <p class="text-gray-500 mt-2">We deliver projects across multiple categories.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </div>
                <h3 class="font-bold text-gray-900">Corporate Websites</h3>
                <p class="text-gray-500 text-sm mt-2">Professional websites that represent your brand and convert visitors.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="font-bold text-gray-900">Web Applications</h3>
                <p class="text-gray-500 text-sm mt-2">Complex applications with custom logic and integrations.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900">Enterprise Systems</h3>
                <p class="text-gray-500 text-sm mt-2">POS, CRM, ERP and other business management platforms.</p>
            </div>
        </div>
    </div>
</section>

{{-- 4. CTA --}}
<section class="py-16 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl p-10">
            <h2 class="text-2xl md:text-3xl font-bold text-white">Have a Project in Mind?</h2>
            <p class="text-blue-100 mt-3">Let's work together to bring your idea to life. We'd love to hear from you.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 px-8 py-3 rounded-xl font-semibold transition mt-6">Start a Conversation</a>
        </div>
    </div>
</section>
@endsection
