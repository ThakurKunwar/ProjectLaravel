@props(['posts'])

@foreach($posts as $post)

<div x-data="{ showCommentForm: false }" class="bg-white rounded-xl shadow-md overflow-hidden mb-6">

    <!-- USER INFO -->
    <div class="flex items-center gap-3 p-4 border-b">
        <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
        <div>
           <a href="/profile/{{$post->user->id}}"> <p class="font-semibold text-gray-800">{{ optional($post->user)->name ?? 'Unknown' }}</p></a>
            <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
        </div>
    </div>

    <!-- IMAGE -->
    <a href="/post/{{$post->id}}">
    @if($post->image)
        <img src="{{ Storage::url($post->image) }}" class="w-full max-h-60 object-cover">
    @endif
    </a>

    <!-- CONTENT -->
    <div class="p-4">
        <h3 class="font-semibold text-lg text-gray-800 mb-1">{{ $post->title }}</h3>
        <p class="text-gray-600 text-sm">{{ $post->description }}</p>
    </div>

    <!-- ACTIONS -->
    <div class="flex justify-between items-center px-4 py-2 border-t text-gray-500 text-sm">
        <div class="flex gap-3">
            
          

  @php
$likedByUser = $post->likes()->where('user_id', auth()->id())->exists();
@endphp

<button class="like-btn hover:text-black transition" data-id="{{ $post->id }}">
   <span class="heart-symbol {{ $likedByUser ? 'text-red-600' : 'text-gray-400' }}">
    {{ $likedByUser ? '❤️' : '♡' }}
</span>
    <span class="likes-count">{{ $post->likes()->count() }}</span>
</button>


            <button @click="showCommentForm = !showCommentForm" class="hover:text-black transition">💬 Comment</button>
            <button class="hover:text-black transition">🔗 Share</button>
        </div>
        @can('delete', $post)
        <form action="/delete-post/{{$post->id}}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button class="hover:text-red-600 transition">🗑 Delete</button>
        </form>
        @endcan
    </div>

    <!-- COMMENTS PREVIEW -->
    <div class="px-4 py-2 border-t">
        @foreach($post->comments->take(3) as $comment)
            @if(auth()->id() === $comment->user->id)
                <p class="text-sm mb-1"><strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}</p>
            @else
                <a href="/profile/{{ $comment->user->id }}">
                    <p class="text-sm mb-1"><strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}</p>
                </a>
            @endif
        @endforeach

        @if($post->comments->count() > 3)
            <a href="/post/{{ $post->id }}" class="text-blue-500 text-sm hover:underline">See more comments...</a>
        @endif
    </div>

    <!-- COMMENT FORM (Toggleable) -->
    <div x-show="showCommentForm" x-transition class="px-4 py-2 border-t">
        @include('components.comment-form', ['post' => $post])
    </div>

</div>

@endforeach



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
$('.like-btn').click(function() {
    let btn = $(this);                     // 1. get the clicked button
    let postId = btn.data('id');    // 2. get post ID from data attribute

 btn.prop('disabled', true); // 🔥 prevent spam

    $.post('/post/' + postId + '/like', {  // 3. send POST request to the route
        _token: '{{ csrf_token() }}'      // 4. CSRF token
    }, function(data) {                    // 5. callback runs when server responds
        btn.find('.likes-count').text(data.likes_count); // 6. update like count

        let heart = btn.find('.heart-symbol');

        if(data.status === 'liked') {
            heart.text('❤️').removeClass('text-gray-400').addClass('text-red-600');
        } else {
            heart.text('♡').removeClass('text-red-600').addClass('text-gray-400');
        }
    });
});
});
</script>