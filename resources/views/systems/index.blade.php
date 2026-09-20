@extends('layouts.app')

@section('seo')
    <x-seo page="systems" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[['name' => __('nav.products'), 'url' => route('systems.index')]]" />
@endpush

@section('content')

<section class="pt-20 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('products.eyebrow') }}</p>
        <h1 class="mt-2 text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ __('products.title') }}</h1>
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ __('products.subtitle') }}</p>
    </div>
</section>

<section class="pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($systems->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($systems as $system)
                    <a href="{{ route('systems.show', $system) }}" class="reveal glass-card rounded-3xl p-6 block" style="--reveal-delay: {{ $loop->index % 6 * 70 }}ms">
                        @if($system->image)
                            <div class="aspect-video rounded-2xl overflow-hidden bg-white/40 mb-5">
                                <img src="{{ Storage::disk('public')->url($system->image) }}" alt="{{ $system->title }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @endif
                        <h2 class="text-lg font-bold text-slate-900">{{ $system->title }}</h2>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed line-clamp-3">{{ $system->description }}</p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700">
                            {{ __('products.detail.cta_button') }}
                            <svg class="w-4 h-4 rtl-flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="glass rounded-3xl p-12 text-center">
                <h2 class="text-xl font-bold text-slate-800">{{ __('products.empty.title') }}</h2>
                <p class="mt-2 text-slate-600">{{ __('products.empty.body') }}</p>
            </div>
        @endif
    </div>
</section>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="reveal text-center text-3xl md:text-4xl font-bold text-slate-900">{{ __('products.why.title') }}</h2>
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach(__('products.why.items') as $item)
                <div class="reveal glass-card rounded-3xl p-6" style="--reveal-delay: {{ $loop->index * 90 }}ms">
                    <h3 class="text-lg font-bold text-slate-900">{{ $item['name'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $item['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal glass-strong rounded-3xl p-10 md:p-14 text-center">
            <h2 class="text-3xl font-bold text-slate-900">{{ __('products.cta.title') }}</h2>
            <p class="mt-4 text-slate-600 max-w-xl mx-auto leading-relaxed">{{ __('products.cta.body') }}</p>
            <a href="{{ route('contact') }}" class="glass-btn-primary inline-block mt-8 px-7 py-3.5 rounded-full font-semibold">
                {{ __('products.cta.button') }}
            </a>
        </div>
    </div>
</section>

@endsection
