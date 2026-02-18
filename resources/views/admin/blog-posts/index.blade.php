@extends('layouts.admin')
@section('page-title', 'Blog Posts')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">All Blog Posts</h2>
        <a href="{{ route('admin.blog-posts.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ New Post</a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Title</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Author</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Status</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Date</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-800/30">
                        <td class="px-4 py-3 font-medium">{{ $post->title }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $post->author->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded-full {{ $post->is_published ? 'bg-green-900/50 text-green-400' : 'bg-yellow-900/50 text-yellow-400' }}">
                                {{ $post->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $post->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.blog-posts.edit', $post) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form method="POST" action="{{ route('admin.blog-posts.destroy', $post) }}" class="inline" onsubmit="return confirm('Delete this post?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-8 text-gray-500">No blog posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $posts->links() }}</div>
</div>
@endsection
