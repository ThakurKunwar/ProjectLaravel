@extends('layouts.dashboard')

@section('content')

<!-- 👤 PROFILE HEADER -->
<div class="bg-white p-6 rounded-xl shadow-md">

    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">

        <!-- PROFILE IMAGE -->
        <div class="w-24 h-24 bg-gray-300 rounded-full"></div>

        <!-- USER INFO -->
        <div class="flex-1 text-center md:text-left">

            <h2 class="text-2xl font-bold text-gray-800">
                {{ $user->name }}
            </h2>

            <p class="text-gray-500 text-sm mb-3">
                Joined {{ $user->created_at->format('M Y') }}
            </p>

            <!-- 📊 STATS -->
            <div class="flex justify-center md:justify-start gap-6 text-sm text-gray-600 mb-4">
                <span><strong>{{ $posts->count() }}</strong> Posts</span>
                <span><strong>0</strong> Followers</span>
                <span><strong>0</strong> Following</span>
            </div>

            <!-- 🔘 ACTION BUTTON -->
            <div>
                @auth
                    @if(auth()->id() === $user->id)
                        <a href="/settings/{{ $user->id }}"
                           class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                            Edit Profile
                        </a>
                    @else
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Follow
                        </button>
                    @endif
                @else
                    <a href="/login"
                       class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                        Login to Follow
                    </a>
                @endauth
            </div>

        </div>

    </div>

</div>

<!-- 📰 USER POSTS -->
<div class="mt-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">
        Posts by {{ $user->name }}
    </h3>

    @forelse($posts as $post)
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 hover:shadow-lg transition">

        <!-- POST IMAGE -->
        @if($post->image)
            <a href="/post/{{ $post->id }}">
                <img src="{{ Storage::url($post->image) }}" class="w-full max-h-96 object-cover">
            </a>
        @endif

        <!-- POST CONTENT -->
        <div class="p-4">
            <h3 class="font-semibold text-lg text-gray-800 mb-1">{{ $post->title }}</h3>
            <p class="text-gray-600 text-sm">{{ $post->description }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ $post->created_at->diffForHumans() }}</p>
        </div>

        <!-- POST STATS & ACTIONS -->
        <div class="flex justify-between items-center px-4 py-2 border-t text-gray-500 text-sm">

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

                    <span>💬 {{ $post->comments()->count() }}</span>
                @else
                    <!-- Guests see likes & comments counts only -->
                    <span>❤️ {{ $post->likes()->count() }}</span>
                    <span>💬 {{ $post->comments()->count() }}</span>
                @endauth
            </div>

            <a href="/post/{{ $post->id }}" class="hover:text-black transition">🔗 View Post</a>

        </div>

        <!-- COMMENTS PREVIEW (up to 3) -->
        @if($post->comments->count() > 0)
        <div class="px-4 py-2 border-t">
            @foreach($post->comments->take(3) as $comment)
                <div class="text-sm mb-1">
                    <a href="/profile/{{ $comment->user->id }}" class="font-semibold text-gray-800 hover:underline">
                        {{ $comment->user->name }}
                    </a>:
                    <span class="text-gray-700">{{ $comment->body }}</span>
                </div>
            @endforeach

            @if($post->comments->count() > 3)
                <a href="/post/{{ $post->id }}" class="text-blue-500 text-sm hover:underline">
                    See all comments...
                </a>
            @endif
        </div>
        @endif

    </div>
    @empty
    <div class="bg-white p-6 rounded-xl shadow-md text-center text-gray-500">
        No posts yet.
    </div>
    @endforelse
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