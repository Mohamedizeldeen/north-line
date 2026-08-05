@php($locale = app()->getLocale())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ site_dir() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f6f8fc">
    <link rel="icon" href="{{ asset('images/fav.png') }}" type="image/x-icon">

    {{-- Title, description, canonical, hreflang, Open Graph, Twitter --}}
    @hasSection('seo')
        @yield('seo')
    @else
        <x-seo />
    @endif

    {{-- Self-hosted. Preload only the weight used by above-the-fold copy. --}}
    <link rel="preload" href="{{ asset('fonts/ibm-plex-sans-arabic-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('fonts/ibm-plex-sans-arabic-700.woff2') }}" as="font" type="font/woff2" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-schema.organization />
    @stack('schema')
    @stack('styles')
</head>
<body class="text-slate-900 antialiased min-h-screen flex flex-col">

    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 glass-nav" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <a href="{{ route('home') }}" class="flex items-center shrink-0" aria-label="{{ config('site.legal_name') }}">
                    <img src="{{ asset('images/logo2.png') }}" alt="{{ config('site.legal_name') }}" class="w-20 h-auto" width="80" height="24">
                </a>

                {{-- Desktop --}}
                <div class="hidden md:flex items-center gap-1">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">{{ __('nav.home') }}</x-nav-link>
                    <x-nav-link href="{{ route('systems.index') }}" :active="request()->routeIs('systems.*')">{{ __('nav.products') }}</x-nav-link>
                    <x-nav-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')">{{ __('nav.work') }}</x-nav-link>
                    <x-nav-link href="{{ route('blog.index') }}" :active="request()->routeIs('blog.*')">{{ __('nav.blog') }}</x-nav-link>
                    <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">{{ __('nav.contact') }}</x-nav-link>
                </div>

                <div class="hidden md:flex items-center gap-3">
                    <x-language-switcher />

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-500 hover:text-slate-900 transition">Dashboard</a>
                        @endif
                    @endauth

                    <a href="{{ route('contact') }}" class="glass-btn-primary px-4 py-2 rounded-full text-sm font-semibold">
                        {{ __('nav.cta') }}
                    </a>
                </div>

                {{-- Mobile toggle --}}
                <div class="flex items-center gap-2 md:hidden">
                    <x-language-switcher />
                    <button @click="mobileOpen = !mobileOpen"
                            class="glass-btn p-2 rounded-full text-slate-700"
                            :aria-expanded="mobileOpen.toString()"
                            aria-label="{{ __('nav.menu') }}">
                        <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div x-show="mobileOpen" x-cloak x-transition.opacity.duration.200ms class="md:hidden pb-4 space-y-1">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="block">{{ __('nav.home') }}</x-nav-link>
                <x-nav-link href="{{ route('systems.index') }}" :active="request()->routeIs('systems.*')" class="block">{{ __('nav.products') }}</x-nav-link>
                <x-nav-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')" class="block">{{ __('nav.work') }}</x-nav-link>
                <x-nav-link href="{{ route('blog.index') }}" :active="request()->routeIs('blog.*')" class="block">{{ __('nav.blog') }}</x-nav-link>
                <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')" class="block">{{ __('nav.contact') }}</x-nav-link>
                <a href="{{ route('contact') }}" class="glass-btn-primary block text-center mt-3 px-4 py-2.5 rounded-full text-sm font-semibold">
                    {{ __('nav.cta') }}
                </a>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
            <div class="glass rounded-2xl px-4 py-3 text-sm text-emerald-800 border-emerald-200/70" role="status">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
            <div class="glass rounded-2xl px-4 py-3 text-sm text-red-800 border-red-200/70" role="alert">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
            <div class="glass rounded-3xl p-8 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div>
                        <img src="{{ asset('images/logo2.png') }}" alt="{{ config('site.legal_name') }}" class="w-24 h-auto mb-4" width="96" height="29">
                        <p class="text-sm text-slate-600 leading-relaxed max-w-xs">{{ __('nav.tagline') }}</p>
                    </div>

                    <div>
                        <h2 class="font-semibold text-sm uppercase tracking-wider text-slate-700 mb-4">{{ __('nav.quick_links') }}</h2>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li><a href="{{ route('systems.index') }}" class="hover:text-blue-700 transition">{{ __('nav.products') }}</a></li>
                            <li><a href="{{ route('projects.index') }}" class="hover:text-blue-700 transition">{{ __('nav.work') }}</a></li>
                            <li><a href="{{ route('blog.index') }}" class="hover:text-blue-700 transition">{{ __('nav.blog') }}</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-blue-700 transition">{{ __('nav.contact') }}</a></li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="font-semibold text-sm uppercase tracking-wider text-slate-700 mb-4">{{ __('nav.get_in_touch') }}</h2>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li>{{ __('nav.address') }}</li>
                            @foreach(config('site.phones') as $phone)
                                <li><a href="tel:{{ $phone['e164'] }}" class="hover:text-blue-700 transition" dir="ltr">{{ $phone['display'] }}</a></li>
                            @endforeach
                            <li><a href="mailto:{{ config('site.email') }}" class="hover:text-blue-700 transition" dir="ltr">{{ config('site.email') }}</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-white/60 mt-8 pt-6 text-center text-sm text-slate-500">
                    &copy; {{ date('Y') }} {{ config('site.legal_name') }}. {{ __('nav.rights') }}
                </div>
            </div>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
