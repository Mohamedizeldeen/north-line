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

<section class="pt-12 pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-700 transition">
            <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5 5-5M18 12H6"/></svg>
            {{ __('nav.work') }}
        </a>

        @if($project->client)
            <p class="mt-4 text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('work.client') }}: {{ $project->client }}</p>
        @endif

        <h1 class="mt-2 text-3xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ $project->title }}</h1>
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ $project->description }}</p>
    </div>
</section>

<x-media-video :url="$project->video_url" :path="$project->video_path"
               :poster="$project->image ? Storage::disk('public')->url($project->image) : null"
               :title="$project->title" />

@if($project->image)
    <section class="pb-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl overflow-hidden p-2">
                <img src="{{ Storage::disk('public')->url($project->image) }}" alt="{{ $project->title }}" class="w-full rounded-2xl">
            </div>
        </div>
    </section>
@endif

@if($project->content)
    <section class="pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-7 md:p-10">
                <div class="prose prose-slate prose-lg max-w-none">
                    {!! Str::markdown($project->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                </div>
            </div>
        </div>
    </section>
@endif

<section class="pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-strong rounded-3xl p-10 md:p-14 text-center">
            <h2 class="text-3xl font-bold text-slate-900">{{ __('work.cta.title') }}</h2>
            <p class="mt-4 text-slate-600 max-w-xl mx-auto leading-relaxed">{{ __('work.cta.body') }}</p>
            <a href="{{ route('contact') }}" class="glass-btn-primary inline-block mt-8 px-7 py-3.5 rounded-full font-semibold">
                {{ __('work.cta.button') }}
            </a>
        </div>
    </div>
</section>

@endsection
