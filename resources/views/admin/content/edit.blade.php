@extends('layouts.admin')
@section('page-title', 'Edit Content')

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">{{ $group }} <span class="text-gray-500 uppercase text-base">· {{ $locale }}</span></h2>
        <a href="{{ route('admin.content.index') }}" class="text-sm text-gray-400 hover:text-white transition">&larr; Back</a>
    </div>

    <form method="POST" action="{{ route('admin.content.update', [$locale, $group]) }}" class="space-y-5"
          @if($locale === 'ar') dir="rtl" @endif>
        @csrf @method('PUT')

        @foreach($items as $key => $value)
            @php $len = mb_strlen($value); @endphp
            <div>
                <label class="block text-xs font-mono text-gray-400 mb-1" dir="ltr">{{ $key }}</label>
                <textarea name="items[{{ $key }}]" rows="{{ mb_strlen($value) > 80 ? 3 : 1 }}"
                          class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ $value }}</textarea>
                @if($group === 'seo' && str_ends_with($key, '.title'))
                    <p class="text-xs mt-1 {{ $len > 60 ? 'text-red-400' : 'text-gray-500' }}" dir="ltr">{{ $len }} / 60 chars</p>
                @elseif($group === 'seo' && str_ends_with($key, '.description'))
                    <p class="text-xs mt-1 {{ ($len < 150 || $len > 160) ? 'text-yellow-400' : 'text-gray-500' }}" dir="ltr">{{ $len }} chars (aim 150–160)</p>
                @endif
            </div>
        @endforeach

        <div class="flex gap-3 sticky bottom-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition shadow-lg">Save Content</button>
            <a href="{{ route('admin.content.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
