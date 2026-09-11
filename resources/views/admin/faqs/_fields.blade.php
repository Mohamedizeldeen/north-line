<div>
    <label class="block text-sm font-medium text-gray-300 mb-1">Language</label>
    <select name="locale" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        @foreach(['ar' => 'Arabic', 'en' => 'English'] as $code => $label)
            <option value="{{ $code }}" @selected(old('locale', $faq->locale ?? 'ar') === $code)>{{ $label }}</option>
        @endforeach
    </select>
    @error('locale') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-300 mb-1">Question</label>
    <input type="text" name="question" value="{{ old('question', $faq->question ?? '') }}" required
           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
    @error('question') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-300 mb-1">Answer</label>
    <textarea name="answer" rows="4" required
              class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('answer', $faq->answer ?? '') }}</textarea>
    @error('answer') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="flex items-center gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-300 mb-1">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}"
               class="w-32 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
    </div>
    <label class="flex items-center gap-2 mt-6">
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $faq->is_published ?? true) ? 'checked' : '' }}
               class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-600 focus:ring-blue-500">
        <span class="text-sm text-gray-300">Published</span>
    </label>
</div>
