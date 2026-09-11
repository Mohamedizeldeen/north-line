@extends('layouts.app')

@section('seo')
    <x-seo :title="$system->title"
           :description="meta_description($system->description, $system->content)"
           :image="$system->image ?? null" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[
        ['name' => __('nav.products'), 'url' => route('systems.index')],
        ['name' => $system->title, 'url' => route('systems.show', $system)],
    ]" />
@endpush

@section('content')

<section class="pt-12 pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('systems.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-700 transition">
            <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5 5-5M18 12H6"/></svg>
            {{ __('nav.products') }}
        </a>

        <h1 class="mt-4 text-3xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ $system->title }}</h1>
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ $system->description }}</p>

        <div class="mt-6 flex flex-wrap items-center gap-3">
            <a href="{{ route('quote', ['service' => $system->slug]) }}"
               class="glass-btn-primary inline-block px-6 py-3 rounded-full font-semibold">
                {{ __('products.detail.quote') }}
            </a>
            @if($system->demo_url)
                <a href="{{ $system->demo_url }}" target="_blank" rel="noopener"
                   class="glass-btn inline-block px-6 py-3 rounded-full font-semibold text-slate-800">
                    {{ __('products.detail.demo') }}
                </a>
            @endif
        </div>
    </div>
</section>

<x-media-video :url="$system->video_url" :path="$system->video_path"
               :poster="$system->image ? Storage::disk('public')->url($system->image) : null"
               :title="$system->title" />

@if($system->image)
    <section class="pb-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl overflow-hidden p-2">
                <img src="{{ Storage::disk('public')->url($system->image) }}" alt="{{ $system->title }}" class="w-full rounded-2xl">
            </div>
        </div>
    </section>
@endif

@if($system->content)
    <section class="pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-7 md:p-10">
                <div class="prose prose-slate prose-lg max-w-none">
                    {!! Str::markdown($system->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
                </div>
            </div>
        </div>
    </section>
@endif

<section class="pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-3xl p-7 md:p-10">
            <h2 class="text-2xl font-bold text-slate-900">{{ __('products.detail.what_you_get') }}</h2>
            <ul class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach(__('products.detail.includes') as $item)
                    <li class="flex items-start gap-2.5 text-slate-700">
                        <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-sm leading-relaxed">{{ $item }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<section class="pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-strong rounded-3xl p-10 md:p-14 text-center">
            <h2 class="text-3xl font-bold text-slate-900">{{ __('products.detail.cta_title') }}</h2>
            <p class="mt-4 text-slate-600 max-w-xl mx-auto leading-relaxed">{{ __('products.detail.cta_body') }}</p>
            <a href="{{ route('contact') }}" class="glass-btn-primary inline-block mt-8 px-7 py-3.5 rounded-full font-semibold">
                {{ __('products.detail.cta_button') }}
            </a>
        </div>
    </div>
</section>

@endsection
