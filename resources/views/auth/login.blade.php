@extends('layouts.app')

@section('seo')
    <x-seo page="login" :noindex="true" />
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="glass-strong rounded-3xl p-8">
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo2.png') }}" alt="{{ config('site.legal_name') }}" class="w-20 h-auto mx-auto mb-4">
                <h1 class="text-2xl font-bold text-slate-900">{{ __('auth.title') }}</h1>
                <p class="text-slate-500 text-sm mt-1">{{ __('auth.subtitle') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('auth.email') }}</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus dir="ltr"
                           @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                           class="w-full bg-white/70 border border-white/80 rounded-xl px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/60 focus:border-blue-400 transition">
                    @error('email') <p id="email-error" class="text-red-600 text-sm mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">{{ __('auth.password') }}</label>
                    <input type="password" id="password" name="password" required dir="ltr"
                           @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                           class="w-full bg-white/70 border border-white/80 rounded-xl px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/60 focus:border-blue-400 transition">
                    @error('password') <p id="password-error" class="text-red-600 text-sm mt-1.5">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600 select-none">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500/60">
                    {{ __('auth.remember') }}
                </label>

                <button type="submit" class="glass-btn-primary w-full py-3 rounded-full font-semibold">
                    {{ __('auth.submit') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
