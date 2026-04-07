<form action="/comments" method="post" class="flex items-center gap-2 bg-gray-50 p-2 rounded shadow-sm">
    @csrf

    <!-- Hidden input for the post ID -->
    <input type="hidden" name="post_id" value="{{ $post->id }}">

    <!-- Compact textarea -->
    <input type="text" name="body" placeholder="Add a comment..." 
           value="{{ old('body') }}" 
           class="flex-1 border border-gray-300 rounded-full px-3 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400"
           required>

    <!-- Submit button -->
    <button type="submit" 
            class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm hover:bg-blue-600 transition">
        ➤
    </button>
</form>