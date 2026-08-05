@extends('layouts.app')

@php
    // Single source for the FAQ: the visible markup below and the FAQPage
    // JSON-LD both render from this array. Marking up a question that is not
    // visible on the page is a structured-data violation, so never let the two
    // drift apart. PHASE 3 moves these strings into lang/{locale}/faq.php.
    $faqs = [
        [
            'question' => 'How long does a typical project take?',
            'answer' => "It depends on the complexity. Simple websites take 2-4 weeks, while complex systems can take 2-6 months. We'll give you a timeline during our initial consultation.",
        ],
        [
            'question' => 'What is your development process?',
            'answer' => "We follow an agile approach: Discovery, Design, Development, and Launch. You'll be involved at every stage with regular updates and feedback sessions.",
        ],
        [
            'question' => 'Do you provide ongoing support?',
            'answer' => 'Yes! We offer maintenance packages to keep your application updated, secure, and running smoothly after launch.',
        ],
        [
            'question' => 'Can you work with our existing systems?',
            'answer' => "Absolutely. We're flexible and can connect to most of the tools you already use. Let us know what you're running and we'll adapt.",
        ],
    ];
@endphp

@section('seo')
    <x-seo page="contact" />
@endsection

@push('schema')
    <x-schema.local-business />
    <x-schema.faq :items="$faqs" />
    <x-schema.breadcrumbs :items="[['name' => __('nav.contact'), 'url' => route('contact')]]" />
@endpush

@section('content')
{{-- 1. Header Section --}}
<section class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Contact</p>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Contact North Line in Muscat, Oman</h1>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">Have a project in mind? We'd love to hear from you. Fill out the form below and we'll get back to you as soon as possible.</p>
        </div>
    </div>
</section>

{{-- 2. Contact Form & Info --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Contact Form --}}
            <div class="lg:col-span-2">
            <form method="POST" action="{{ route('contact.store') }}" class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 space-y-5 shadow-sm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                </div>

                <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="e.g. Project Inquiry"
                       class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('subject') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                <textarea name="message" rows="6" required placeholder="Tell us about your project..."
                      class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('message') }}</textarea>
                @error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition w-full sm:w-auto">
                Send Message
                </button>
            </form>
            </div>

            {{-- Contact Info --}}
            <div class="space-y-6">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                    <h3 class="font-semibold text-gray-900">Email</h3>
                    <p class="text-gray-500 text-sm">info@northline-dev.com</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                    <h3 class="font-semibold text-gray-900">Phone</h3>
                    <p class="text-gray-500 text-sm">(+968) 9808-4952</p>
                    <p class="text-gray-500 text-sm">(+968) 9982-2690</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                    <h3 class="font-semibold text-gray-900">Address</h3>
                    <p class="text-gray-500 text-sm">Al Khoud, Muscat, Oman</p>
                    </div>
                </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-100 rounded-2xl p-6 shadow-sm">
                <h3 class="font-semibold text-gray-900 mb-4">What to expect</h3>
                <ul class="text-gray-600 text-sm space-y-3">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>We'll respond within 24 hours</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Free project consultation</span>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>No obligation quote</span>
                </li>
                </ul>
            </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. FAQ Section --}}
<section class="py-16 bg-gray-50 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Frequently Asked Questions</h2>
        </div>
        <div class="space-y-4">
            @foreach($faqs as $faq)
                <div class="bg-white border border-gray-200 rounded-xl p-5">
                    <h3 class="font-semibold text-gray-900">{{ $faq['question'] }}</h3>
                    <p class="text-gray-500 text-sm mt-2">{{ $faq['answer'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 4. CTA --}}
<section class="py-16 border-t border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl p-10">
            <h2 class="text-2xl md:text-3xl font-bold text-white">Let's Build Something Great</h2>
            <p class="text-blue-100 mt-3">Whether you need a website, web app, or enterprise system — we're here to help.</p>
            <a href="{{ route('projects.index') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 px-8 py-3 rounded-xl font-semibold transition mt-6">View Our Work</a>
        </div>
    </div>
</section>
@endsection
