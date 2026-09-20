@extends('layouts.admin')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-xl">
    <h2 class="text-xl font-bold mb-6">Edit User</h2>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required dir="ltr"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            @error('email') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">New Password <span class="text-gray-500">(leave empty to keep current)</span></label>
            <input type="password" name="password"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            @error('password') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Confirm New Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>

        <div>
            <label class="flex items-center gap-2">
                <input type="hidden" name="is_admin" value="0">
                <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                       @if($user->is(auth()->user())) disabled @endif
                       class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
                <span class="text-sm text-gray-300">Administrator (full access to this panel)</span>
            </label>
            @if($user->is(auth()->user()))
                <input type="hidden" name="is_admin" value="1">
                <p class="text-gray-500 text-xs mt-1">You cannot change your own admin access.</p>
            @endif
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
