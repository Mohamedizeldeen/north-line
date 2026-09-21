@extends('layouts.admin')
@section('page-title', 'Projects')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold">All Projects</h2>
        <a href="{{ route('admin.projects.create') }}" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ New Project</a>
    </div>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Title</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Client</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Status</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Featured</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($projects as $project)
                    <tr class="hover:bg-gray-800/30">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $project->title_ar ?: $project->title_en }}</div>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span class="text-[10px] px-1.5 py-0.5 rounded {{ $project->title_ar ? 'bg-purple-900/50 text-purple-300' : 'bg-gray-800 text-gray-600' }}">AR</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded {{ $project->title_en ? 'bg-blue-900/50 text-blue-300' : 'bg-gray-800 text-gray-600' }}">EN</span>
                                @if($project->title_en && $project->title_ar)
                                    <span class="text-xs text-gray-500">{{ $project->title_en }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $project->client ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded-full {{ $project->is_published ? 'bg-green-900/50 text-green-400' : 'bg-yellow-900/50 text-yellow-400' }}">
                                {{ $project->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($project->is_featured)
                                <span class="text-xs text-blue-400">★ Featured</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Delete this project? This removes both languages.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-8 text-gray-500">No projects yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $projects->links() }}</div>
</div>
@endsection
