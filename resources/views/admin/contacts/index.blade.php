@extends('layouts.admin')
@section('page-title', 'Contact Messages')

@section('content')
<div class="space-y-4">
    <h2 class="text-xl font-bold">Contact Messages</h2>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Status</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Name</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Email</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Subject</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Date</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($submissions as $sub)
                    <tr class="hover:bg-gray-800/30 {{ $sub->status === 'unread' ? 'bg-blue-900/10' : '' }}">
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded-full {{ $sub->status === 'unread' ? 'bg-red-900/50 text-red-400' : 'bg-gray-800 text-gray-400' }}">
                                {{ $sub->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-medium {{ $sub->status === 'unread' ? 'text-white' : 'text-gray-400' }}">{{ $sub->name }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $sub->email }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $sub->subject ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $sub->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.contacts.show', $sub) }}" class="text-blue-400 hover:text-blue-300">View</a>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $sub) }}" class="inline" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-8 text-gray-500">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $submissions->links() }}</div>
</div>
@endsection
