@extends('layouts.app')

@php
    // Single source for the FAQ: the visible markup below and the FAQPage
    // JSON-LD both render from this array. Marking up a question that is not
    // visible on the page is a structured-data violation, so the two can never
    // be allowed to drift apart.
    //
    // Admin-managed FAQs (the faqs table) win when present; otherwise the
    // lang-file defaults are used — so a fresh database still renders a FAQ.
    $faqs = \App\Models\Faq::inLocale()->published()->orderBy('sort_order')->get()
        ->map(fn ($f) => ['question' => $f->question, 'answer' => $f->answer])->all();

    if (empty($faqs)) {
        $faqs = __('contact.faqs');
    }
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

<section class="pt-20 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('contact.eyebrow') }}</p>
        <h1 class="mt-2 text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ __('contact.title') }}</h1>
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ __('contact.subtitle') }}</p>
    </div>
</section>

<section class="pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Form --}}
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('contact.store') }}" class="glass rounded-3xl p-6 md:p-8 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                                {{ __('contact.form.name') }} <span class="text-red-500" aria-hidden="true">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
                                   class="w-full bg-white/70 border border-white/80 rounded-xl px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/60 focus:border-blue-400 transition">
                            @error('name') <p id="name-error" class="text-red-600 text-sm mt-1.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                                {{ __('contact.form.email') }} <span class="text-red-500" aria-hidden="true">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required dir="ltr"
                                   @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                                   class="w-full bg-white/70 border border-white/80 rounded-xl px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/60 focus:border-blue-400 transition">
                            @error('email') <p id="email-error" class="text-red-600 text-sm mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('contact.form.subject') }}</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                               placeholder="{{ __('contact.form.subject_placeholder') }}"
                               class="w-full bg-white/70 border border-white/80 rounded-xl px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/60 focus:border-blue-400 transition">
                        @error('subject') <p class="text-red-600 text-sm mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700 mb-1.5">
                            {{ __('contact.form.message') }} <span class="text-red-500" aria-hidden="true">*</span>
                        </label>
                        <textarea id="message" name="message" rows="6" required
                                  placeholder="{{ __('contact.form.message_placeholder') }}"
                                  class="w-full bg-white/70 border border-white/80 rounded-xl px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/60 focus:border-blue-400 transition">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-600 text-sm mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="glass-btn-primary w-full sm:w-auto px-8 py-3.5 rounded-full font-semibold">
                        {{ __('contact.form.submit') }}
                    </button>
                </form>
            </div>

            {{-- Details --}}
            <div class="space-y-5">
                <div class="glass rounded-3xl p-6 space-y-5">
                    <div class="flex items-start gap-3">
                        <div class="glass-subtle w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-slate-900">{{ __('contact.info.email') }}</h2>
                            <a href="mailto:{{ config('site.email') }}" class="text-sm text-slate-600 hover:text-blue-700 transition" dir="ltr">{{ config('site.email') }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="glass-subtle w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-slate-900">{{ __('contact.info.phone') }}</h2>
                            @foreach(config('site.phones') as $phone)
                                <a href="tel:{{ $phone['e164'] }}" class="block text-sm text-slate-600 hover:text-blue-700 transition" dir="ltr">{{ $phone['display'] }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="glass-subtle w-10 h-10 rounded-xl flex items-center justify-center shrink-0 text-orange-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-slate-900">{{ __('contact.info.address') }}</h2>
                            <p class="text-sm text-slate-600">{{ __('contact.info.address_value') }}</p>
                        </div>
                    </div>
                </div>

                <div class="glass rounded-3xl p-6">
                    <ul class="space-y-3">
                        @foreach(__('contact.perks') as $perk)
                            <li class="flex items-start gap-2.5 text-sm text-slate-700">
                                <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                {{ $perk }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-4 pt-4 border-t border-white/60 text-sm text-slate-500">{{ __('contact.info.hours') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-center text-3xl md:text-4xl font-bold text-slate-900">{{ __('contact.faq_title') }}</h2>
        <div class="mt-10 space-y-4">
            @foreach($faqs as $faq)
                <div class="glass rounded-3xl p-6">
                    <h3 class="font-bold text-slate-900">{{ $faq['question'] }}</h3>
                    <p class="mt-2.5 text-slate-600 leading-relaxed">{{ $faq['answer'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
