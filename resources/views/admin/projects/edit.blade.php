@extends('layouts.admin')
@section('page-title', 'Edit Project')

@section('content')
@php $primary = $project; @endphp
<div class="max-w-5xl">
    <h2 class="text-xl font-bold mb-6">Edit Project</h2>

    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')

        @include('admin.partials.bilingual-fields', [
            'item' => $project,
            'fields' => [
                ['key' => 'title', 'label' => 'Title'],
                ['key' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                ['key' => 'content', 'label' => 'Detailed Content', 'type' => 'textarea', 'rows' => 8],
            ],
        ])

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Client</label>
                <input type="text" name="client" value="{{ old('client', $primary->client) }}"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Live URL</label>
                <input type="url" name="live_url" value="{{ old('live_url', $primary->live_url) }}"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Technologies Used <span class="text-gray-500">(comma separated)</span></label>
            <input type="text" name="technologies_used" value="{{ old('technologies_used', is_array($primary->technologies_used) ? implode(', ', $primary->technologies_used) : $primary->technologies_used) }}" placeholder="Laravel, Vue.js, MySQL"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Image</label>
            @if($primary->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($primary->image) }}" alt="" class="w-32 h-20 object-cover rounded-lg">
                </div>
            @endif
            <input type="file" name="image" accept="image/*"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white file:text-sm">
            @if($primary->image)
                <label class="flex items-center gap-2 mt-2">
                    <input type="checkbox" name="remove_image" value="1"
                           class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-red-600 focus:ring-red-500">
                    <span class="text-sm text-red-400">Remove current image</span>
                </label>
            @endif
        </div>

        @include('admin.partials.video-fields', ['videoUrl' => old('video_url', $primary->video_url), 'currentPath' => $primary->video_path])

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $primary->sort_order) }}"
                   class="w-32 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $primary->is_published) ? 'checked' : '' }}
                       class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
                <span class="text-sm text-gray-300">Published</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $primary->is_featured) ? 'checked' : '' }}
                       class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
                <span class="text-sm text-gray-300">Featured</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Update Project</button>
            <a href="{{ route('admin.projects.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
