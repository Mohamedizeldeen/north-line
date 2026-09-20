@props(['client'])

@php
    $tile = 'flex items-center justify-center rounded-2xl bg-white border border-slate-200 p-5 shadow-sm';
@endphp

@if($client->url)
    <a href="{{ $client->url }}" target="_blank" rel="noopener"
       {{ $attributes->merge(['class' => $tile.' transition hover:shadow-md']) }}
       aria-label="{{ $client->name }}">
        @if($client->logo)
            <img src="{{ Storage::disk('public')->url($client->logo) }}" alt="{{ $client->name }}"
                 class="max-h-full max-w-full object-contain" loading="lazy">
        @else
            <span class="text-slate-800 font-bold text-center leading-snug">{{ $client->name }}</span>
        @endif
    </a>
@else
    <div {{ $attributes->merge(['class' => $tile]) }}>
        @if($client->logo)
            <img src="{{ Storage::disk('public')->url($client->logo) }}" alt="{{ $client->name }}"
                 class="max-h-full max-w-full object-contain" loading="lazy">
        @else
            <span class="text-slate-800 font-bold text-center leading-snug">{{ $client->name }}</span>
        @endif
    </div>
@endif
