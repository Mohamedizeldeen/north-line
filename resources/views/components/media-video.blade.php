@props([
    'url' => null,      // external link (YouTube / Vimeo / direct file)
    'path' => null,     // uploaded file, relative path on the public disk
    'poster' => null,   // cover image URL, used as the <video> poster
    'title' => '',
])

@php
    $embed = video_embed_url($url);
    $fileUrl = $path ? Storage::disk('public')->url($path) : null;
    $hasVideo = $fileUrl || $embed || $url;
@endphp

@if($hasVideo)
    <section class="pb-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl overflow-hidden p-2">
                @if($fileUrl)
                    <video controls preload="metadata"
                           @if($poster) poster="{{ $poster }}" @endif
                           class="w-full rounded-2xl aspect-video bg-black">
                        <source src="{{ $fileUrl }}">
                    </video>
                @elseif($embed)
                    <div class="aspect-video w-full rounded-2xl overflow-hidden bg-black">
                        <iframe src="{{ $embed }}" title="{{ $title }}"
                                class="w-full h-full" loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    </div>
                @else
                    <video controls preload="metadata"
                           @if($poster) poster="{{ $poster }}" @endif
                           class="w-full rounded-2xl aspect-video bg-black">
                        <source src="{{ $url }}">
                    </video>
                @endif
            </div>
        </div>
    </section>
@endif
