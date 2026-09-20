<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - North Line Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell text-white antialiased min-h-screen" x-data="{ sidebarOpen: true }">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col shrink-0"
               :class="sidebarOpen ? '' : 'hidden'" >
            <div class="p-4 border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center font-bold text-sm">NL</div>
                    <span class="text-lg font-bold">Admin Panel</span>
                </a>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <x-admin-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.blog-posts.index') }}" :active="request()->routeIs('admin.blog-posts.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Blog Posts
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.projects.index') }}" :active="request()->routeIs('admin.projects.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Projects
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.technologies.index') }}" :active="request()->routeIs('admin.technologies.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    Technologies
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.systems.index') }}" :active="request()->routeIs('admin.systems.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Systems
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.clients.index') }}" :active="request()->routeIs('admin.clients.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a3 3 0 10-3-3"/></svg>
                    Clients
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.contacts.index') }}" :active="request()->routeIs('admin.contacts.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Contact Messages
                    @php $unreadCount = \App\Models\ContactSubmission::unread()->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.quotes.index') }}" :active="request()->routeIs('admin.quotes.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg>
                    Quote Requests
                    @php $unreadQuotes = \App\Models\QuoteRequest::unread()->count(); @endphp
                    @if($unreadQuotes > 0)
                        <span class="ml-auto bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadQuotes }}</span>
                    @endif
                </x-admin-nav-link>

                <p class="px-3 pt-5 pb-1 text-xs font-semibold uppercase tracking-wider text-gray-500">Manage</p>

                <x-admin-nav-link href="{{ route('admin.content.index') }}" :active="request()->routeIs('admin.content.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Page Content &amp; SEO
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.faqs.index') }}" :active="request()->routeIs('admin.faqs.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    FAQs
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.settings.edit') }}" :active="request()->routeIs('admin.settings.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Site Settings
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Users
                </x-admin-nav-link>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-sm text-gray-400 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Website
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-sm text-gray-400 hover:text-red-400 transition w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Top Bar --}}
            <header class="h-16 bg-gray-900/50 border-b border-gray-800 flex items-center px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-400 hover:text-white mr-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold">@yield('page-title', 'Dashboard')</h1>
                <div class="ml-auto text-sm text-gray-400">
                    {{ auth()->user()->name }}
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-900/50 border-b border-green-700 text-green-300 px-6 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-900/50 border-b border-red-700 text-red-300 px-6 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>
