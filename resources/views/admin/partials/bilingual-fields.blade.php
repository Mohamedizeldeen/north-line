@php
    $columns = [
        'ar' => ['label' => 'العربية (Arabic)', 'dir' => 'rtl', 'color' => 'text-purple-300', 'model' => $ar ?? null],
        'en' => ['label' => 'English', 'dir' => 'ltr', 'color' => 'text-blue-300', 'model' => $en ?? null],
    ];
@endphp
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @foreach($columns as $locale => $col)
        <div class="space-y-4 border border-gray-800 rounded-xl p-4">
            <h3 class="text-sm font-semibold {{ $col['color'] }}">{{ $col['label'] }}</h3>

            @foreach($fields as $field)
                @php
                    $name = $field['key'].'_'.$locale;
                    $value = old($name, $col['model']->{$field['key']} ?? '');
                @endphp
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">{{ $field['label'] }}</label>
                    @if(($field['type'] ?? 'input') === 'textarea')
                        <textarea name="{{ $name }}" rows="{{ $field['rows'] ?? 4 }}" dir="{{ $col['dir'] }}"
                                  class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ $value }}</textarea>
                    @else
                        <input type="text" name="{{ $name }}" value="{{ $value }}" dir="{{ $col['dir'] }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @endif
                    @error($name) <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>
    @endforeach
</div>
<p class="text-xs text-gray-500">Fill in at least one language. Leave a side blank to skip that language for this item.</p>
