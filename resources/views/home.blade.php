@extends('layouts.app')
@section('title', 'Home')
@section('meta_description', 'North Line - We build websites, web applications, and systems that power businesses.')

@section('content')
{{-- 1. Hero Section --}}
<section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-cyan-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 relative">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-blue-100 border border-blue-200 rounded-full px-4 py-1.5 text-sm text-blue-700 mb-6">
                <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                Building Digital Solutions
            </div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold leading-tight text-gray-900">
                We Build
                <span class="bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600 bg-clip-text text-transparent"> Websites, Apps</span>
                <br>& Systems
            </h1>
            <p class="text-gray-600 text-lg md:text-xl mt-6 max-w-2xl mx-auto leading-relaxed">
                North Line delivers high-quality web development solutions. From stunning websites to powerful SaaS platforms, we turn your ideas into reality.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10">
                <a href="{{ route('contact') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl font-semibold text-lg transition shadow-lg shadow-blue-600/25">
                    Start Your Project
                </a>
                <a href="{{ route('projects.index') }}" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-3.5 rounded-xl font-semibold text-lg transition border border-gray-300 shadow-sm">
                    View Our Work
                </a>
            </div>
        </div>
    </div>
</section>

{{-- 2. Services Section --}}
<section class="py-20 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Our Services</p>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">What We Do</h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">We provide end-to-end development services tailored to your business needs.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:border-blue-300 hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-blue-100 transition">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Websites</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Beautiful, responsive websites that make a lasting impression. From landing pages to complex corporate sites.</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:border-cyan-300 hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-cyan-50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-cyan-100 transition">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Web Applications</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Custom web applications built with modern technologies. Scalable, secure, and built for performance.</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:border-purple-300 hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-purple-100 transition">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Systems & SaaS</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Enterprise-grade systems like POS, CRM, and ERP. Ready-to-use solutions or custom-built for your needs.</p>
            </div>
        </div>
    </div>
</section>

{{-- 3. Why Choose Us --}}
<section class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Why Choose Us</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">We Build Software That Drives Results</h2>
                <p class="text-gray-500 mt-4 leading-relaxed">We're not just developers — we're partners in your digital success. Our team combines technical expertise with business acumen to deliver solutions that make a real impact.</p>

                <div class="mt-8 space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Fast Delivery</h4>
                            <p class="text-gray-500 text-sm mt-1">We deliver projects on-time without compromising on quality. Agile methodology keeps things moving.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Secure & Reliable</h4>
                            <p class="text-gray-500 text-sm mt-1">Security-first approach with industry best practices. Your data and users are always protected.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Ongoing Support</h4>
                            <p class="text-gray-500 text-sm mt-1">We don't disappear after launch. Continuous maintenance and support to keep things running smoothly.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-br from-blue-100 to-cyan-100 rounded-3xl p-12 flex items-center justify-center">
                <div class="text-center">
                    <div class="w-24 h-24 p-2 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-6">
<img src="{{ asset('images/logo.png') }}" alt="North Line Logo">
                </div>
                    <p class="text-gray-700 font-semibold text-lg">Your Digital Partner</p>
                    <p class="text-gray-500 text-sm mt-1">From concept to completion</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 4. How We Work --}}
<section class="py-20 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Our Process</p>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">How We Work</h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">A streamlined process that takes your project from idea to launch.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-blue-600 font-bold text-xl">01</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Discovery</h3>
                <p class="text-gray-500 text-sm">We learn about your business, goals, and requirements to define the project scope.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-cyan-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-cyan-600 font-bold text-xl">02</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Design</h3>
                <p class="text-gray-500 text-sm">We create wireframes and designs that align with your brand and user expectations.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-purple-600 font-bold text-xl">03</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Development</h3>
                <p class="text-gray-500 text-sm">We build your solution using modern technologies with iterative feedback cycles.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-green-600 font-bold text-xl">04</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Launch & Support</h3>
                <p class="text-gray-500 text-sm">We deploy your project and provide ongoing maintenance and support.</p>
            </div>
        </div>
    </div>
</section>

{{-- 5. Featured Projects --}}
@if($featuredProjects->isNotEmpty())
<section class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Portfolio</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Featured Projects</h2>
                <p class="text-gray-500 mt-2">Some of our recent work we're proud of.</p>
            </div>
            <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hidden sm:block">View All &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredProjects as $project)
                <a href="{{ route('projects.show', $project) }}" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-300 transition">
                    @if($project->image)
                        <div class="aspect-video bg-gray-100 overflow-hidden">
                            <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition">{{ $project->title }}</h3>
                        <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $project->description }}</p>
                        @if($project->technologies_used)
                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @foreach(array_slice($project->technologies_used, 0, 3) as $tech)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 6. Stats / Numbers --}}
<section class="py-20 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Our Impact</p>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Numbers That Speak</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-extrabold text-blue-600">50+</div>
                <p class="text-gray-500 mt-2 text-sm font-medium">Projects Delivered</p>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-extrabold text-cyan-600">30+</div>
                <p class="text-gray-500 mt-2 text-sm font-medium">Happy Clients</p>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-extrabold text-purple-600">5+</div>
                <p class="text-gray-500 mt-2 text-sm font-medium">Years Experience</p>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-extrabold text-green-600">99%</div>
                <p class="text-gray-500 mt-2 text-sm font-medium">Client Satisfaction</p>
            </div>
        </div>
    </div>
</section>

{{-- 7. Systems / SaaS --}}
@if($systems->isNotEmpty())
<section class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Products</p>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Our Systems & SaaS</h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">Ready-to-use software solutions for your business.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min($systems->count(), 4) }} gap-6">
            @foreach($systems as $system)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-blue-200 transition">
                    @if($system->image)
                        <img src="{{ Storage::url($system->image) }}" alt="{{ $system->title }}" class="w-full h-40 object-cover rounded-xl mb-4">
                    @endif
                    <h3 class="text-lg font-bold text-gray-900">{{ $system->title }}</h3>
                    <p class="text-gray-500 text-sm mt-2 line-clamp-3">{{ $system->description }}</p>
                    <div class="mt-4 flex gap-3">
                        @if($system->demo_url)
                            <a href="{{ $system->demo_url }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Try Demo</a>
                        @endif
                        <a href="{{ route('systems.show', $system) }}" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition border border-gray-300">Learn More</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('systems.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All Systems &rarr;</a>
        </div>
    </div>
</section>
@endif

{{-- 8. Technologies --}}
@if($technologies->isNotEmpty())
<section class="py-20 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Tech Stack</p>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Technologies We Use</h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">We work with modern, battle-tested technologies.</p>
        </div>

        <div class="flex flex-wrap justify-center gap-4">
            @foreach($technologies as $tech)
                <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-4 py-3 hover:shadow-md hover:border-gray-300 transition">
                    @if($tech->icon)
                        <img src="{{ Storage::url($tech->icon) }}" alt="{{ $tech->name }}" class="w-6 h-6">
                    @endif
                    <span class="text-sm font-medium text-gray-700">{{ $tech->name }}</span>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('technologies.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All Technologies &rarr;</a>
        </div>
    </div>
</section>
@endif

{{-- 9. Latest Blog Posts --}}
@if($latestPosts->isNotEmpty())
<section class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-blue-600 font-semibold text-sm uppercase tracking-wider mb-2">Blog</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Latest Blog Posts</h2>
                <p class="text-gray-500 mt-2">Insights, tutorials, and updates from our team.</p>
            </div>
            <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hidden sm:block">View All &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($latestPosts as $post)
                <a href="{{ route('blog.show', $post) }}" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:border-gray-300 transition">
                    @if($post->featured_image)
                        <div class="aspect-video bg-gray-100 overflow-hidden">
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    @endif
                    <div class="p-5">
                        <div class="text-xs text-gray-400 mb-2">{{ $post->published_at->format('M d, Y') }}</div>
                        <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition">{{ $post->title }}</h3>
                        @if($post->excerpt)
                            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $post->excerpt }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 10. CTA Section --}}
<section class="py-20 border-t border-gray-100 bg-gradient-to-br from-blue-600 to-cyan-500">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white">Ready to Start Your Project?</h2>
        <p class="text-blue-100 mt-4 text-lg max-w-2xl mx-auto">Let's discuss how we can help bring your vision to life. Get in touch with us today.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
            <a href="{{ route('contact') }}" class="bg-white hover:bg-gray-100 text-blue-600 px-8 py-3.5 rounded-xl font-semibold text-lg transition shadow-lg">
                Contact Us
            </a>
            <a href="{{ route('projects.index') }}" class="bg-transparent border-2 border-white/50 hover:border-white text-white px-8 py-3.5 rounded-xl font-semibold text-lg transition">
                View Projects
            </a>
        </div>
    </div>
</section>
@endsection
