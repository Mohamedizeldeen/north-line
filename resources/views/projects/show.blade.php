@extends('layouts.app')

@section('seo')
    <x-seo :title="$project->title"
           :description="meta_description($project->description, $project->content)"
           :image="$project->image ?? null" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[
        ['name' => __('nav.work'), 'url' => route('projects.index')],
        ['name' => $project->title, 'url' => route('projects.show', $project)],
    ]" />
@endpush

@section('content')
{{-- 1. Project Header --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('projects.index') }}" class="text-sm text-blue-600 hover:text-blue-700 transition mb-4 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Projects
        </a>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">{{ $project->title }}</h1>
        <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-500">
            @if($project->client)
                <span>Client: <strong class="text-gray-900">{{ $project->client }}</strong></span>
            @endif
            @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank" class="text-blue-600 hover:underline font-medium">View Live &rarr;</a>
            @endif
        </div>
    </div>
</section>

{{-- 2. Project Image --}}
@if($project->image)
<section class="pb-4">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl overflow-hidden shadow-lg">
            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-full">
        </div>
    </div>
</section>
@endif

{{-- 3. Technologies Used --}}
@if($project->technologies_used)
<section class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Technologies Used</h2>
        <div class="flex flex-wrap gap-2">
            @foreach($project->technologies_used as $tech)
                <span class="text-sm bg-blue-50 text-blue-700 px-3 py-1 rounded-lg border border-blue-200">{{ $tech }}</span>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 4. Project Details --}}
<section class="py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-gray-700 leading-relaxed text-lg">
            <p>{{ $project->description }}</p>
        </div>

        @if($project->content)
            <div class="mt-8 prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! Str::markdown($project->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
            </div>
        @endif
    </div>
</section>

{{-- 5. CTA --}}
<section class="py-12 border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8 text-center">
            <h2 class="text-xl font-bold text-gray-900">Like What You See?</h2>
            <p class="text-gray-500 mt-2">Let's build something amazing together. Get in touch to discuss your project.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition mt-4">Start Your Project</a>
        </div>
    </div>
</section>
@endsection
