@extends('layouts.admin')
@section('page-title', 'Create Blog Post')

@section('content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold mb-6">Create New Blog Post</h2>

    <form method="POST" action="{{ route('admin.blog-posts.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            @error('title') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Excerpt</label>
            <textarea name="excerpt" rows="2"
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('excerpt') }}</textarea>
            @error('excerpt') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Content</label>
            <textarea name="content" rows="12" required
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('content') }}</textarea>
            @error('content') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Featured Image</label>
            <input type="file" name="featured_image" accept="image/*"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white file:text-sm">
            @error('featured_image') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published') ? 'checked' : '' }}
                   class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
            <label for="is_published" class="text-sm text-gray-300">Publish immediately</label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Create Post</button>
            <a href="{{ route('admin.blog-posts.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
