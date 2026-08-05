@extends('layouts.app')

@section('seo')
    <x-seo page="systems" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[['name' => __('nav.systems'), 'url' => route('systems.index')]]" />
@endpush

@section('content')
{{-- 1. Header Section --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Products</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Ready-Made Business Systems for Oman</h1>
            <p class="text-gray-500 mt-3 max-w-2xl mx-auto">Ready-to-use software solutions built to streamline your business operations. Try our demos and see what works for you.</p>
        </div>
    </div>
</section>

{{-- 2. Systems List --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($systems->isNotEmpty())
            <div class="space-y-8">
                @foreach($systems as $system)
                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-300 transition">
                        <div class="flex flex-col md:flex-row">
                            @if($system->image)
                                <div class="md:w-1/3 aspect-video md:aspect-auto bg-gray-100">
                                    <img src="{{ Storage::url($system->image) }}" alt="{{ $system->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="flex-1 p-6 md:p-8 flex flex-col justify-center">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $system->title }}</h2>
                                <p class="text-gray-500 mt-3 leading-relaxed">{{ $system->description }}</p>
                                <div class="flex gap-3 mt-6">
                                    @if($system->demo_url)
                                        <a href="{{ $system->demo_url }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                                            Try Demo
                                        </a>
                                    @endif
                                    <a href="{{ route('systems.show', $system) }}" class="bg-white hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-medium transition border border-gray-300">
                                        Learn More
                                    </a>
                                    <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-700 px-4 py-2.5 text-sm font-medium transition">
                                        Request Info &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <h2 class="text-xl font-bold text-gray-400">No systems listed yet</h2>
                <p class="text-gray-500 mt-2">We're preparing our product showcase. Check back soon!</p>
            </div>
        @endif
    </div>
</section>

{{-- 3. Why Our Systems --}}
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Why Choose Our Systems</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900">Ready to Use</h3>
                <p class="text-gray-500 text-sm mt-2">Deploy quickly with minimal setup. Start using the system the same day.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900">Customizable</h3>
                <p class="text-gray-500 text-sm mt-2">Adapt the system to your specific business needs and workflows.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900">Full Support</h3>
                <p class="text-gray-500 text-sm mt-2">Get training, maintenance, and ongoing support from our team.</p>
            </div>
        </div>
    </div>
</section>

{{-- 4. Custom System CTA --}}
<section class="py-16 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl p-10">
            <h2 class="text-2xl md:text-3xl font-bold text-white">Need a Custom System?</h2>
            <p class="text-blue-100 mt-3">Don't see what you need? We build custom systems tailored to your business requirements.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 px-8 py-3 rounded-xl font-semibold transition mt-6">Contact Us</a>
        </div>
    </div>
</section>
@endsection
