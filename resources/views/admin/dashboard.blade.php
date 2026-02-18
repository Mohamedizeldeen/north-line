@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
            <div class="text-sm text-gray-400">Blog Posts</div>
            <div class="text-2xl font-bold mt-1">{{ $stats['blog_posts'] }}</div>
        </div>
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
            <div class="text-sm text-gray-400">Projects</div>
            <div class="text-2xl font-bold mt-1">{{ $stats['projects'] }}</div>
        </div>
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
            <div class="text-sm text-gray-400">Technologies</div>
            <div class="text-2xl font-bold mt-1">{{ $stats['technologies'] }}</div>
        </div>
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
            <div class="text-sm text-gray-400">Systems</div>
            <div class="text-2xl font-bold mt-1">{{ $stats['systems'] }}</div>
        </div>
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
            <div class="text-sm text-gray-400">Unread Messages</div>
            <div class="text-2xl font-bold mt-1 {{ $stats['unread_messages'] > 0 ? 'text-red-400' : '' }}">{{ $stats['unread_messages'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Posts --}}
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Recent Blog Posts</h2>
                <a href="{{ route('admin.blog-posts.create') }}" class="text-sm text-blue-400 hover:text-blue-300">+ New Post</a>
            </div>
            @forelse($recentPosts as $post)
                <div class="flex items-center justify-between py-3 border-b border-gray-800 last:border-0">
                    <div>
                        <div class="font-medium text-sm">{{ $post->title }}</div>
                        <div class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $post->is_published ? 'bg-green-900/50 text-green-400' : 'bg-yellow-900/50 text-yellow-400' }}">
                        {{ $post->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No blog posts yet.</p>
            @endforelse
        </div>

        {{-- Recent Messages --}}
        <div class="bg-gray-900 rounded-xl border border-gray-800 p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Recent Messages</h2>
                <a href="{{ route('admin.contacts.index') }}" class="text-sm text-blue-400 hover:text-blue-300">View All</a>
            </div>
            @forelse($recentMessages as $msg)
                <div class="flex items-center justify-between py-3 border-b border-gray-800 last:border-0">
                    <div>
                        <div class="font-medium text-sm {{ $msg->status === 'unread' ? 'text-white' : 'text-gray-400' }}">{{ $msg->name }}</div>
                        <div class="text-xs text-gray-500">{{ Str::limit($msg->message, 50) }}</div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $msg->status === 'unread' ? 'bg-red-900/50 text-red-400' : 'bg-gray-800 text-gray-400' }}">
                        {{ $msg->status }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No messages yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
