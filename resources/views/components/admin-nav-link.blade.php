@props(['href', 'active' => false])

<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ $active ? 'text-white bg-blue-600/20 border border-blue-500/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
    {{ $slot }}
</a>
