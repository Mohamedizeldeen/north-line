@extends('layouts.admin')
@section('page-title', 'Add FAQ')

@section('content')
<div class="max-w-4xl">
    <h2 class="text-xl font-bold mb-6">Add New FAQ</h2>

    <form method="POST" action="{{ route('admin.faqs.store') }}" class="space-y-5">
        @csrf

        @include('admin.partials.bilingual-fields', [
            'item' => null,
            'fields' => [
                ['key' => 'question', 'label' => 'Question'],
                ['key' => 'answer', 'label' => 'Answer', 'type' => 'textarea', 'rows' => 4],
            ],
        ])

        <div class="flex items-center gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="w-32 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <label class="flex items-center gap-2 mt-6">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                       class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
                <span class="text-sm text-gray-300">Published</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Add FAQ</button>
            <a href="{{ route('admin.faqs.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
