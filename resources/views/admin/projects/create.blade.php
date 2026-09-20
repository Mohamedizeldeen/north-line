@extends('layouts.admin')
@section('page-title', 'Create Project')

@section('content')
<div class="max-w-5xl">
    <h2 class="text-xl font-bold mb-6">Create New Project</h2>

    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        @include('admin.partials.bilingual-fields', [
            'ar' => null,
            'en' => null,
            'fields' => [
                ['key' => 'title', 'label' => 'Title'],
                ['key' => 'description', 'label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                ['key' => 'content', 'label' => 'Detailed Content', 'type' => 'textarea', 'rows' => 8],
            ],
        ])

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Client</label>
                <input type="text" name="client" value="{{ old('client') }}"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Live URL</label>
                <input type="url" name="live_url" value="{{ old('live_url') }}"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Technologies Used <span class="text-gray-500">(comma separated)</span></label>
            <input type="text" name="technologies_used" value="{{ old('technologies_used') }}" placeholder="Laravel, Vue.js, MySQL"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Image</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white file:text-sm">
            @error('image') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        @include('admin.partials.video-fields', ['videoUrl' => old('video_url'), 'currentPath' => null])

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                   class="w-32 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                       class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
                <span class="text-sm text-gray-300">Publish</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                       class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
                <span class="text-sm text-gray-300">Featured</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Create Project</button>
            <a href="{{ route('admin.projects.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
