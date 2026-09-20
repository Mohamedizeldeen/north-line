@extends('layouts.app')

@section('seo')
    <x-seo page="quote" />
@endsection

@push('schema')
    <x-schema.breadcrumbs :items="[['name' => __('quote.title'), 'url' => route('quote')]]" />
@endpush

@section('content')

<section class="pt-16 pb-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-sm font-semibold uppercase tracking-wider text-blue-700">{{ __('quote.eyebrow') }}</p>
        <h1 class="mt-2 text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 text-balance">{{ __('quote.title') }}</h1>
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ __('quote.subtitle') }}</p>
    </div>
</section>

<section class="pb-24">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('quote.store') }}" class="reveal glass rounded-3xl p-6 md:p-8 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="q-name" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('quote.form.name') }} <span class="text-red-600">*</span></label>
                    <input type="text" id="q-name" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl bg-white/70 border border-slate-300 px-4 py-2.5 text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('name')<p class="text-red-600 text-sm mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="q-company" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('quote.form.company') }} <span class="text-slate-400 font-normal">({{ __('quote.form.optional') }})</span></label>
                    <input type="text" id="q-company" name="company" value="{{ old('company') }}"
                           class="w-full rounded-xl bg-white/70 border border-slate-300 px-4 py-2.5 text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('company')<p class="text-red-600 text-sm mt-1.5">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="q-email" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('quote.form.email') }} <span class="text-red-600">*</span></label>
                    <input type="email" id="q-email" name="email" value="{{ old('email') }}" required dir="ltr"
                           class="w-full rounded-xl bg-white/70 border border-slate-300 px-4 py-2.5 text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('email')<p class="text-red-600 text-sm mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="q-phone" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('quote.form.phone') }} <span class="text-slate-400 font-normal">({{ __('quote.form.optional') }})</span></label>
                    <input type="tel" id="q-phone" name="phone" value="{{ old('phone') }}" dir="ltr"
                           class="w-full rounded-xl bg-white/70 border border-slate-300 px-4 py-2.5 text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('phone')<p class="text-red-600 text-sm mt-1.5">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="q-service" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('quote.form.service') }}</label>
                <select id="q-service" name="service"
                        class="w-full rounded-xl bg-white/70 border border-slate-300 px-4 py-2.5 text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="">{{ __('quote.form.service_any') }}</option>
                    @foreach($services as $service)
                        <option value="{{ $service->title }}"
                            @selected(old('service', $selected === $service->slug ? $service->title : null) === $service->title)>
                            {{ $service->title }}
                        </option>
                    @endforeach
                </select>
                @error('service')<p class="text-red-600 text-sm mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="q-message" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('quote.form.message') }}</label>
                <textarea id="q-message" name="message" rows="5" placeholder="{{ __('quote.form.message_placeholder') }}"
                          class="w-full rounded-xl bg-white/70 border border-slate-300 px-4 py-2.5 text-slate-900 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('message') }}</textarea>
                @error('message')<p class="text-red-600 text-sm mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-between gap-4 pt-1">
                <button type="submit" class="glass-btn-primary px-7 py-3 rounded-full font-semibold">
                    {{ __('quote.form.submit') }}
                </button>
                <p class="text-sm text-slate-500">{{ __('quote.note') }}</p>
            </div>
        </form>
    </div>
</section>

@endsection
