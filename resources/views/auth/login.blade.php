@extends('layouts.app')

@section('seo')
    <x-seo page="login" :noindex="true" />
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 bg-gray-50">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center font-bold text-lg text-white mx-auto mb-3">NL</div>
                <h1 class="text-2xl font-bold text-gray-900">Welcome Back</h1>
                <p class="text-gray-500 text-sm mt-1">Sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember"
                               class="w-4 h-4 bg-gray-50 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-500">Remember me</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
