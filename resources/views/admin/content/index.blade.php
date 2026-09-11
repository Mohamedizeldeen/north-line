@extends('layouts.admin')
@section('page-title', 'Page Content & SEO')

@section('content')
<div class="space-y-4">
    <h2 class="text-xl font-bold">Page Content &amp; SEO</h2>
    <p class="text-sm text-gray-400 max-w-2xl">Edit the text of any page in either language. Changes override the built-in defaults; clearing a field restores the default. The <span class="text-gray-200">seo</span> group holds each page's title &amp; meta description.</p>

    <div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-300">Group</th>
                    @foreach($locales as $locale)
                        <th class="text-left px-4 py-3 font-medium text-gray-300 uppercase">{{ $locale }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($groups as $group)
                    <tr class="hover:bg-gray-800/30">
                        <td class="px-4 py-3 font-medium">{{ $group }}</td>
                        @foreach($locales as $locale)
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.content.edit', [$locale, $group]) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
