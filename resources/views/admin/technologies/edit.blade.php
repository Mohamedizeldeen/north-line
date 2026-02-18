@extends('layouts.admin')
@section('page-title', 'Edit Technology')

@section('content')
<div class="max-w-xl">
    <h2 class="text-xl font-bold mb-6">Edit Technology</h2>

    <form method="POST" action="{{ route('admin.technologies.update', $technology) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $technology->name) }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Category</label>
            <input type="text" name="category" value="{{ old('category', $technology->category) }}" placeholder="e.g. Frontend, Backend, Database, DevOps"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('description', $technology->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Icon/Logo</label>
            @if($technology->icon)
                <div class="mb-2">
                    <img src="{{ Storage::url($technology->icon) }}" alt="" class="w-10 h-10 rounded">
                </div>
            @endif
            <input type="file" name="icon" accept="image/*"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white file:text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $technology->sort_order) }}"
                   class="w-32 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Update Technology</button>
            <a href="{{ route('admin.technologies.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
