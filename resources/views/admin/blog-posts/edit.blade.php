@extends('layouts.admin')
@section('page-title', 'Edit Blog Post')

@section('content')
@php $primary = $blogPost; @endphp
<div class="max-w-5xl">
    <h2 class="text-xl font-bold mb-6">Edit Blog Post</h2>

    <form method="POST" action="{{ route('admin.blog-posts.update', $blogPost) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')

        @include('admin.partials.bilingual-fields', [
            'item' => $blogPost,
            'fields' => [
                ['key' => 'title', 'label' => 'Title'],
                ['key' => 'excerpt', 'label' => 'Excerpt', 'type' => 'textarea', 'rows' => 2],
                ['key' => 'content', 'label' => 'Content', 'type' => 'textarea', 'rows' => 12],
            ],
        ])

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Featured Image</label>
            @if($primary->featured_image)
                <div class="mb-2">
                    <img src="{{ Storage::url($primary->featured_image) }}" alt="" class="w-32 h-20 object-cover rounded-lg">
                </div>
            @endif
            <input type="file" name="featured_image" accept="image/*"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white file:text-sm">
            @error('featured_image') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            @if($primary->featured_image)
                <label class="flex items-center gap-2 mt-2">
                    <input type="checkbox" name="remove_featured_image" value="1"
                           class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-red-600 focus:ring-red-500">
                    <span class="text-sm text-red-400">Remove current image</span>
                </label>
            @endif
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $primary->is_published) ? 'checked' : '' }}
                   class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
            <label for="is_published" class="text-sm text-gray-300">Published</label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Update Post</button>
            <a href="{{ route('admin.blog-posts.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
