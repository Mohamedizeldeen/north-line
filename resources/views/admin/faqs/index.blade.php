@extends('layouts.admin')
@section('page-title', 'FAQs')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">FAQs</h2>
        <a href="{{ route('admin.faqs.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ Add FAQ</a>
    </div>
    <p class="text-sm text-gray-400">Shown on the contact page and marked up as FAQ structured data. When empty, the built-in default FAQs are used.</p>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Lang</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Question</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Published</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Order</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($faqs as $faq)
                    <tr class="hover:bg-gray-800/30">
                        <td class="px-4 py-3"><span class="text-xs bg-gray-700 text-gray-300 px-2 py-0.5 rounded uppercase">{{ $faq->locale }}</span></td>
                        <td class="px-4 py-3 font-medium">{{ \Illuminate\Support\Str::limit($faq->question, 70) }}</td>
                        <td class="px-4 py-3">
                            @if($faq->is_published)
                                <span class="text-xs bg-green-900/50 text-green-300 px-2 py-0.5 rounded-full">Published</span>
                            @else
                                <span class="text-xs bg-gray-700 text-gray-300 px-2 py-0.5 rounded-full">Hidden</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $faq->sort_order }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="inline" onsubmit="return confirm('Delete this FAQ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-8 text-gray-500">No FAQs yet — the default set is being shown on the site.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $faqs->links() }}</div>
</div>
@endsection
