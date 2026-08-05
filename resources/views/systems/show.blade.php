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
{{-- 1. System Header --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 py-12 md:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('systems.index') }}" class="text-sm text-blue-600 hover:text-blue-700 transition mb-4 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Systems
        </a>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">{{ $system->title }}</h1>
        <p class="text-gray-500 text-lg mt-4 leading-relaxed">{{ $system->description }}</p>
        @if($system->demo_url)
            <div class="mt-6">
                <a href="{{ $system->demo_url }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Try Live Demo
                </a>
            </div>
        @endif
    </div>
</section>

{{-- 2. System Image --}}
@if($system->image)
<section class="pb-4">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl overflow-hidden shadow-lg">
            <img src="{{ Storage::url($system->image) }}" alt="{{ $system->title }}" class="w-full">
        </div>
    </div>
</section>
@endif

{{-- 3. System Content --}}
@if($system->content)
<section class="py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            {!! Str::markdown($system->content, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}
        </div>
    </div>
</section>
@endif

{{-- 4. Key Benefits --}}
<section class="py-12 bg-gray-50 border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">What You Get</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-start gap-3 bg-white border border-gray-200 rounded-xl p-4">
                <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-gray-700 text-sm">Full system installation & setup</span>
            </div>
            <div class="flex items-start gap-3 bg-white border border-gray-200 rounded-xl p-4">
                <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-gray-700 text-sm">Team training & onboarding</span>
            </div>
            <div class="flex items-start gap-3 bg-white border border-gray-200 rounded-xl p-4">
                <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-gray-700 text-sm">Custom configuration options</span>
            </div>
            <div class="flex items-start gap-3 bg-white border border-gray-200 rounded-xl p-4">
                <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-gray-700 text-sm">Ongoing technical support</span>
            </div>
        </div>
    </div>
</section>

{{-- 5. CTA --}}
<section class="py-12 border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl p-8 text-center">
            <h2 class="text-xl font-bold text-white">Interested in this system?</h2>
            <p class="text-blue-100 mt-2">Contact us to learn more or request a personalized demo.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 px-6 py-2.5 rounded-lg font-medium transition mt-4">Get in Touch</a>
        </div>
    </div>
</section>
@endsection
