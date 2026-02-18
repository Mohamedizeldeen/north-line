@extends('layouts.admin')
@section('page-title', 'Edit System')

@section('content')
<div class="max-w-3xl">
    <h2 class="text-xl font-bold mb-6">Edit System</h2>

    <form method="POST" action="{{ route('admin.systems.update', $system) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $system->title) }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            @error('title') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
            <textarea name="description" rows="3" required
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('description', $system->description) }}</textarea>
            @error('description') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Detailed Content</label>
            <textarea name="content" rows="8"
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('content', $system->content) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Demo URL</label>
            <input type="url" name="demo_url" value="{{ old('demo_url', $system->demo_url) }}"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Image / Screenshot</label>
            @if($system->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($system->image) }}" alt="" class="w-32 h-20 object-cover rounded-lg">
                </div>
            @endif
            <input type="file" name="image" accept="image/*"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white file:text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $system->sort_order) }}"
                   class="w-32 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $system->is_published) ? 'checked' : '' }}
                   class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
            <label for="is_published" class="text-sm text-gray-300">Published</label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Update System</button>
            <a href="{{ route('admin.systems.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
