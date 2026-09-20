{{-- Expects: $videoUrl (string|null), $currentPath (string|null) --}}
<div>
    <label class="block text-sm font-medium text-gray-300 mb-1">Video URL <span class="text-gray-500">(YouTube / Vimeo / direct link — optional)</span></label>
    <input type="url" name="video_url" value="{{ $videoUrl }}" placeholder="https://youtu.be/..."
           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
    @error('video_url') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-300 mb-1">Or upload a video <span class="text-gray-500">(MP4/WebM, optional)</span></label>
    @if(!empty($currentPath))
        <p class="text-green-400 text-xs mb-2">A video file is currently uploaded. Choose a new file to replace it.</p>
    @endif
    <input type="file" name="video_path" accept="video/mp4,video/webm"
           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white file:text-sm">
    <p class="text-gray-500 text-xs mt-1">An uploaded file takes priority over the link.</p>
    @error('video_path') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror

    @if(!empty($currentPath) || !empty($videoUrl))
        <label class="flex items-center gap-2 mt-2">
            <input type="checkbox" name="remove_video" value="1"
                   class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-red-600 focus:ring-red-500">
            <span class="text-sm text-red-400">Remove current video</span>
        </label>
    @endif
</div>
