@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto mt-6">

  <!-- POST HEADER -->
<div class="flex items-center gap-3 mb-4">
    <!-- Profile Picture -->
    <a href="/profile/{{ optional($post->user)->id ?? '#' }}">
        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-300">
            <img src="{{ optional($post->user)->profile_picture 
                        ? Storage::url($post->user->profile_picture) 
                        : '/default-avatar.png' }}" 
                 alt="{{ optional($post->user)->name ?? 'User' }}'s profile picture"
                 class="w-full h-full object-cover">
        </div>
    </a>

    <!-- User Name & Post Time -->
    <div>
        <p class="font-semibold text-gray-800">
            <a href="/profile/{{ optional($post->user)->id ?? '#' }}" class="hover:underline">
                {{ optional($post->user)->name ?? 'Unknown' }}
            </a>
        </p>
        <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
    </div>
</div>

    <!-- POST IMAGE -->
    @if($post->image)
        <img src="{{ Storage::url($post->image) }}" class="w-full max-h-80 object-cover rounded-xl mb-4">
    @endif

    <!-- POST CONTENT -->
    <div class="mb-4">
        <h2 class="font-bold text-xl text-gray-800 mb-2">{{ $post->title }}</h2>
        <p class="text-gray-700">{{ $post->description }}</p>
    </div>

    <!-- POST STATS & ACTIONS -->
    <div class="flex justify-between items-center text-gray-500 mb-6">

        <div class="flex gap-4 items-center">

            @auth
                @php
                    $likedByUser = $post->likes()->where('user_id', auth()->id())->exists();
                @endphp

                <button class="like-btn flex items-center gap-1 hover:text-black transition" data-id="{{ $post->id }}">
                    <span class="heart-symbol {{ $likedByUser ? 'text-red-600' : 'text-gray-400' }}">
                        {{ $likedByUser ? '❤️' : '♡' }}
                    </span>
                    <span class="likes-count">{{ $post->likes()->count() }}</span>
                </button>

                <button class="hover:text-black transition">💬 Comment</button>

            @else
                <!-- Guests: read-only like + comment count -->
                <div class="flex items-center gap-1">
                    <span class="text-gray-400">❤️</span>
                    <span>{{ $post->likes()->count() }}</span>
                </div>

                <div class="flex items-center gap-1">
                    <span class="text-gray-400">💬</span>
                    <span>{{ $post->comments()->count() }}</span>
                </div>
            @endauth

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

    <!-- COMMENTS -->
    <div class="bg-white p-4 rounded-xl shadow-md mb-6">
        <h3 class="font-semibold mb-3 text-gray-800">Comments ({{ $post->comments->count() }})</h3>

        @forelse($post->comments as $comment)
            <div class="mb-2">
                <p class="text-sm">
                    <strong>
                        @if(auth()->check() && auth()->id() === $comment->user->id)
                            You
                        @else
                            <a href="/profile/{{ $comment->user->id }}" class="hover:underline">{{ $comment->user->name }}</a>
                        @endif
                    </strong>: {{ $comment->body }}
                </p>
            </div>
        @empty
            <p class="text-gray-400 text-sm">No comments yet.</p>
        @endforelse
    </div>

    <!-- COMMENT FORM (Logged-in users only) -->
    @auth
    <div class="bg-white p-4 rounded-xl shadow-md">
        @include('components.comment-form', ['post' => $post])
    </div>
    @endauth

</div>

@auth
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.like-btn').click(function() {
        let btn = $(this);
        let postId = btn.data('id');

        btn.prop('disabled', true);

        $.post('/post/' + postId + '/like', {
            _token: '{{ csrf_token() }}'
        }, function(data) {
            btn.find('.likes-count').text(data.likes_count);

            let heart = btn.find('.heart-symbol');
            if(data.status === 'liked') {
                heart.text('❤️').removeClass('text-gray-400').addClass('text-red-600');
            } else {
                heart.text('♡').removeClass('text-red-600').addClass('text-gray-400');
            }

            btn.prop('disabled', false);
        });
    });
});
</script>
@endauth

@endsection