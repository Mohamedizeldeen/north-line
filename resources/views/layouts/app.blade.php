<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- -fav --}}
    <link rel="icon" href="{{ asset('images/fav.png') }}" type="image/x-icon">
    <title>@yield('title', 'North Line') - North Line Development</title>
    <meta name="description" content="@yield('meta_description', 'North Line - We build websites, web apps, and systems that power businesses.')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-white text-gray-900 antialiased min-h-screen flex flex-col">
    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="North Line Logo" class="w-20 h-auto">
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
                    <x-nav-link href="{{ route('blog.index') }}" :active="request()->routeIs('blog.*')">Blog</x-nav-link>
                    <x-nav-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')">Projects</x-nav-link>
                    <x-nav-link href="{{ route('technologies.index') }}" :active="request()->routeIs('technologies.*')">Technologies</x-nav-link>
                    <x-nav-link href="{{ route('systems.index') }}" :active="request()->routeIs('systems.*')">Systems</x-nav-link>
                    <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact</x-nav-link>
                </div>

                {{-- CTA --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900 transition">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-900 transition">Logout</button>
                        </form>
                    @endauth
                    <a href="{{ route('contact') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Get in Touch</a>
                </div>

                {{-- Mobile Toggle --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-gray-600 hover:text-gray-900">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" x-transition class="md:hidden pb-4 space-y-1">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')" class="block">Home</x-nav-link>
                <x-nav-link href="{{ route('blog.index') }}" :active="request()->routeIs('blog.*')" class="block">Blog</x-nav-link>
                <x-nav-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')" class="block">Projects</x-nav-link>
                <x-nav-link href="{{ route('technologies.index') }}" :active="request()->routeIs('technologies.*')" class="block">Technologies</x-nav-link>
                <x-nav-link href="{{ route('systems.index') }}" :active="request()->routeIs('systems.*')" class="block">Systems</x-nav-link>
                <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')" class="block">Contact</x-nav-link>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-center text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-center text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-50 border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="North Line Logo" class="w-30 h-auto">
                    </div>
                    <p class="text-gray-500 text-sm max-w-md">We build websites, web applications, and systems that power businesses. Your vision, our expertise.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-gray-700 mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition">Blog</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-blue-600 transition">Projects</a></li>
                        <li><a href="{{ route('systems.index') }}" class="hover:text-blue-600 transition">Systems</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-blue-600 transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-sm uppercase tracking-wider text-gray-700 mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li>Al Khoud, Muscat, Oman</li>
                        <li>(+968) 9808-4952 - (+968) 9982-2690</li>
                        <li><a href="mailto:info@northline-dev.com" class="hover:text-blue-600 transition">info@northline-dev.com</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} North Line. All rights reserved.
            </div>
        </div>
    </footer>

    {{-- Alpine.js CDN for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
