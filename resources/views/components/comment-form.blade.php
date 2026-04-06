<form action="/comments" method="post" class="flex flex-col gap-2">
    @csrf
  
    <!-- Hidden input for the post this comment belongs to -->
    <input type="hidden" name="post_id" value="{{ $post->id }}">

    <!-- Comment textarea -->
    <textarea name="body" placeholder="Write a comment..." 
              class="border rounded p-2 w-full text-sm" 
              rows="2" required>{{ old('body') }}</textarea>

    <!-- Submit button -->
    <button type="submit" 
            class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition">
        Comment
    </button>
</form>