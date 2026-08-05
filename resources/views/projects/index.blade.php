@extends('layouts.app')

@section('seo')
    <x-seo page="projects" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[['name' => __('nav.work'), 'url' => route('projects.index')]]" />
@endpush

@section('content')

<section class="pt-20 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('work.eyebrow') }}</p>
        <h1 class="mt-2 text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ __('work.title') }}</h1>
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ __('work.subtitle') }}</p>
    </div>
</section>

<section class="pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($projects->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="glass-card rounded-3xl overflow-hidden block">
                        @if($project->image)
                            <div class="aspect-video bg-white/40 overflow-hidden">
                                <img src="{{ Storage::disk('public')->url($project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @endif
                        <div class="p-6">
                            @if($project->client)
                                <p class="text-xs font-semibold uppercase tracking-wider text-blue-700">{{ $project->client }}</p>
                            @endif
                            <h2 class="mt-1 text-lg font-bold text-slate-900">{{ $project->title }}</h2>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed line-clamp-3">{{ $project->description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">{{ $projects->links() }}</div>
        @else
            <div class="glass rounded-3xl p-12 text-center">
                <h2 class="text-xl font-bold text-slate-800">{{ __('work.empty.title') }}</h2>
                <p class="mt-2 text-slate-600">{{ __('work.empty.body') }}</p>
            </div>
        @endif
    </div>
</section>

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
