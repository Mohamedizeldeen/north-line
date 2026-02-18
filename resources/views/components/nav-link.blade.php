@props(['href', 'active' => false])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'px-3 py-2 rounded-lg text-sm font-medium transition ' . ($active ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50')]) }}>
    {{ $slot }}
</a>
