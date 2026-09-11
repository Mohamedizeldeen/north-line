@extends('layouts.admin')
@section('page-title', 'Add FAQ')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-xl font-bold mb-6">Add New FAQ</h2>

    <form method="POST" action="{{ route('admin.faqs.store') }}" class="space-y-5">
        @csrf
        @include('admin.faqs._fields', ['faq' => null])
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Add FAQ</button>
            <a href="{{ route('admin.faqs.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
