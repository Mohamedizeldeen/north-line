@extends('layouts.admin')
@section('page-title', 'Technologies')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">All Technologies</h2>
        <a href="{{ route('admin.technologies.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ Add Technology</a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Name</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Category</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Order</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($technologies as $tech)
                    <tr class="hover:bg-gray-800/30">
                        <td class="px-4 py-3 font-medium flex items-center gap-2">
                            @if($tech->icon)
                                <img src="{{ Storage::url($tech->icon) }}" alt="" class="w-6 h-6 rounded">
                            @endif
                            {{ $tech->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $tech->category ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $tech->sort_order }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.technologies.edit', $tech) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form method="POST" action="{{ route('admin.technologies.destroy', $tech) }}" class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-8 text-gray-500">No technologies yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $technologies->links() }}</div>
</div>
@endsection
