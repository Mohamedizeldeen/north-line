@extends('layouts.admin')
@section('page-title', 'Users')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">Users</h2>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ Add User</a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Name</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Email</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Role</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-800/30">
                        <td class="px-4 py-3 font-medium">{{ $user->name }} @if($user->is(auth()->user()))<span class="text-gray-500 text-xs">(you)</span>@endif</td>
                        <td class="px-4 py-3 text-gray-400">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->is_admin)
                                <span class="text-xs bg-blue-900/50 text-blue-300 px-2 py-0.5 rounded-full">Admin</span>
                            @else
                                <span class="text-xs bg-gray-700 text-gray-300 px-2 py-0.5 rounded-full">User</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                            @unless($user->is(auth()->user()))
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-8 text-gray-500">No users yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
