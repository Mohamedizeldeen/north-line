@extends('layouts.app')

@section('seo')
    <x-seo page="clients" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[['name' => __('clients.title'), 'url' => route('clients.index')]]" />
@endpush

@section('content')

<section class="pt-20 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('clients.eyebrow') }}</p>
        <h1 class="mt-2 text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ __('clients.title') }}</h1>
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ __('clients.subtitle') }}</p>
    </div>
</section>

<section class="pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($clients->isNotEmpty())
            <div class="flex flex-wrap justify-center gap-5">
                @foreach($clients as $client)
                    <x-client-logo :client="$client" class="reveal h-28 w-48" style="--reveal-delay: {{ $loop->index % 8 * 60 }}ms" />
                @endforeach
            </div>
        @else
            <div class="glass rounded-3xl p-12 text-center">
                <h2 class="text-xl font-bold text-slate-800">{{ __('clients.empty.title') }}</h2>
                <p class="mt-2 text-slate-600">{{ __('clients.empty.body') }}</p>
            </div>
        @endif
    </div>
</section>

@endsection
