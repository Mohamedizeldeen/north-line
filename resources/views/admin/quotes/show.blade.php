@extends('layouts.admin')
@section('page-title', 'View Quote Request')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Quote request from {{ $quote->name }}</h2>
        <a href="{{ route('admin.quotes.index') }}" class="text-sm text-gray-400 hover:text-white transition">&larr; Back to Requests</a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Name</div>
                <div class="font-medium">{{ $quote->name }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Company</div>
                <div class="text-gray-300">{{ $quote->company ?? '—' }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Email</div>
                <div><a href="mailto:{{ $quote->email }}" class="text-blue-400 hover:underline">{{ $quote->email }}</a></div>
            </div>
            <div>
                <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Phone</div>
                <div class="text-gray-300">{{ $quote->phone ?? '—' }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Service</div>
                <div class="text-gray-300">{{ $quote->service ?? '—' }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500 uppercase tracking-wider mb-1">Date</div>
                <div class="text-gray-300">{{ $quote->created_at->format('M d, Y \a\t H:i') }}</div>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-4">
            <div class="text-xs text-gray-500 uppercase tracking-wider mb-2">Details</div>
            <div class="text-gray-200 whitespace-pre-wrap leading-relaxed">{{ $quote->message ?: '—' }}</div>
        </div>
    </div>

    <div class="mt-4 flex gap-3">
        <a href="mailto:{{ $quote->email }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Reply via Email</a>
        <form method="POST" action="{{ route('admin.quotes.destroy', $quote) }}" onsubmit="return confirm('Delete this request?')">
            @csrf @method('DELETE')
            <button type="submit" class="bg-red-600/20 hover:bg-red-600/40 text-red-400 px-4 py-2 rounded-lg text-sm font-medium transition">Delete</button>
        </form>
    </div>
</div>
@endsection
