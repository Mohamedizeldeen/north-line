@extends('layouts.admin')
@section('page-title', 'Clients')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">Clients</h2>
        <a href="{{ route('admin.clients.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ Add Client</a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Logo</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Name</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Published</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Order</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($clients as $client)
                    <tr class="hover:bg-gray-800/30">
                        <td class="px-4 py-3">
                            @if($client->logo)
                                <span class="inline-flex items-center justify-center w-16 h-10 bg-white rounded p-1">
                                    <img src="{{ Storage::url($client->logo) }}" alt="" class="max-h-full max-w-full object-contain">
                                </span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $client->name }}</td>
                        <td class="px-4 py-3">
                            @if($client->is_published)
                                <span class="text-xs bg-green-900/50 text-green-300 px-2 py-0.5 rounded-full">Published</span>
                            @else
                                <span class="text-xs bg-gray-700 text-gray-300 px-2 py-0.5 rounded-full">Hidden</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $client->sort_order }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.clients.edit', $client) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-8 text-gray-500">No clients yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $clients->links() }}</div>
</div>
@endsection
