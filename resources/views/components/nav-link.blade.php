@props(['href', 'active' => false])

<a href="{{ $href }}"
   @if($active) aria-current="page" @endif
   {{ $attributes->merge([
        'class' => 'px-3 py-2 rounded-full text-sm font-medium transition '
            . ($active
                ? 'text-blue-700 bg-white/70 shadow-[inset_0_1px_0_0_rgba(255,255,255,0.9)]'
                : 'text-slate-600 hover:text-blue-700 hover:bg-white/50'),
   ]) }}>
    {{ $slot }}
</a>
