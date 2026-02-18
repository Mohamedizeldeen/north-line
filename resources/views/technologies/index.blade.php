@extends('layouts.app')
@section('title', 'Technologies')
@section('meta_description', 'Explore the technologies and tools North Line uses to build modern web solutions.')

@section('content')
{{-- 1. Header Section --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Tech Stack</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Technologies We Use</h1>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">We work with modern, battle-tested technologies to deliver reliable solutions.</p>
        </div>
    </div>
</section>

{{-- 2. Technologies by Category --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @forelse($technologies as $category => $techs)
            <div class="mb-12">
                <h2 class="text-xl font-bold mb-6 text-gray-800">
                    {{ $category ?: 'Other' }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($techs as $tech)
                        <div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md hover:border-gray-300 transition">
                            <div class="flex items-center gap-3 mb-3">
                                @if($tech->icon)
                                    <img src="{{ Storage::url($tech->icon) }}" alt="{{ $tech->name }}" class="w-8 h-auto rounded">
                                @else
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-cyan-100 rounded flex items-center justify-center text-sm font-bold text-blue-600">
                                        {{ strtoupper(substr($tech->name, 0, 1)) }}
                                    </div>
                                @endif
                                <h3 class="font-semibold text-gray-900">{{ $tech->name }}</h3>
                            </div>
                            @if($tech->description)
                                <p class="text-gray-500 text-sm">{{ $tech->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                <h2 class="text-xl font-bold text-gray-400">No technologies listed yet</h2>
                <p class="text-gray-500 mt-2">Check back soon!</p>
            </div>
        @endforelse
    </div>
</section>

{{-- 3. Why These Technologies --}}
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Why We Choose These Tools</h2>
            <p class="text-gray-500 mt-2 max-w-xl mx-auto">Every technology in our stack is chosen for a reason.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Performance</h3>
                <p class="text-gray-500 text-sm">We select technologies that deliver fast load times and smooth user experiences.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Security</h3>
                <p class="text-gray-500 text-sm">Security is built-in — we use frameworks and tools with strong security features.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Scalability</h3>
                <p class="text-gray-500 text-sm">Our tech stack scales with your business, from startup to enterprise.</p>
            </div>
        </div>
    </div>
</section>

{{-- 4. CTA --}}
<section class="py-16 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl p-10">
            <h2 class="text-2xl md:text-3xl font-bold text-white">Need a Specific Technology?</h2>
            <p class="text-blue-100 mt-3">We're flexible with our stack. Tell us what you need and we'll make it happen.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 px-8 py-3 rounded-xl font-semibold transition mt-6">Talk to Us</a>
        </div>
    </div>
</section>
@endsection
