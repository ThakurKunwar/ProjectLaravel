@extends('layouts.dashboard')

@section('content')

<!-- 👤 PROFILE HEADER -->
<div class="bg-white p-6 rounded-xl shadow-md">

    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">

        <!-- PROFILE IMAGE -->
      <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-300">
    <img src="{{ $user->profile_picture 
                ? Storage::url($user->profile_picture) 
                : '/default-avatar.png' }}" 
         alt="{{ $user->name }}'s profile picture"
         class="w-full h-full object-cover">
</div>

        <!-- USER INFO -->
        <div class="flex-1 text-center md:text-left">

            <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-gray-500 text-sm mb-3">Joined {{ $user->created_at->format('M Y') }}</p>

            <!-- 📊 STATS -->
            <div class="flex justify-center md:justify-start gap-6 text-sm text-gray-600 mb-4">
                <span><strong>{{ $posts->count() }}</strong> Posts</span>
           <span><strong class="followers-count">{{$user->followers()->count()}}</strong> Followers</span>
           <span><strong class="following-count">{{$user->following()->count()}}</strong> Following</span>
            </div>

            <!-- 🔘 ACTION BUTTONS -->
            <div class="flex justify-center md:justify-start gap-4">
                @auth
                    @if(auth()->id() === $user->id)
                        <a href="/settings/{{ $user->id }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                            Edit Profile
                        </a>
                    @else
                        @php
                            $isFollowing = auth()->user()
                                ->following()
                                ->where('following_id', $user->id)
                                ->exists();
                        @endphp
                        <button 
                            type="button"
                            class="follow-btn px-4 py-2 rounded-lg text-white {{ $isFollowing ? 'bg-gray-600' : 'bg-blue-600' }}"
                            data-id="{{ $user->id }}"
                        >
                            {{ $isFollowing ? 'Unfollow' : 'Follow' }}
                        </button>
                    @endif
                @else
                    <a href="/login" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
                        Login to Follow
                    </a>
                @endauth
            </div>

        </div>

    </div>

</div>

<!-- 📰 USER POSTS -->
<div class="mt-6">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Posts by {{ $user->name }}</h3>

    @forelse($posts as $post)
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 hover:shadow-lg transition">

        @if($post->image)
            <a href="/post/{{ $post->id }}">
                <img src="{{ Storage::url($post->image) }}" class="w-full max-h-96 object-cover">
            </a>
        @endif

        <div class="p-4">
            <h3 class="font-semibold text-lg text-gray-800 mb-1">{{ $post->title }}</h3>
            <p class="text-gray-600 text-sm">{{ $post->description }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ $post->created_at->diffForHumans() }}</p>
        </div>

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
                    <span>❤️ {{ $post->likes()->count() }}</span>
                    <span>💬 {{ $post->comments()->count() }}</span>
                @endauth
            </div>
            <a href="/post/{{ $post->id }}" class="hover:text-black transition">🔗 View Post</a>
        </div>

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

    // LIKE BUTTON
    $(document).on('click', '.like-btn', function() {
        let btn = $(this);
        let postId = btn.data('id');

        btn.prop('disabled', true);

        $.post('/post/' + postId + '/like', {_token: '{{ csrf_token() }}'}, function(data) {
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

    // FOLLOW BUTTON
    $(document).on('click', '.follow-btn', function() {
        let btn = $(this);
        let userId = btn.data('id');

        btn.prop('disabled', true);

        $.post('/follow/' + userId, {_token: '{{ csrf_token() }}'}, function(data) {

            // Update follower count dynamically
            $('.followers-count').text(data.followers_count);
             $('.following-count').text(data.following_count);
            

            if(data.status === 'followed') {
                btn.text('Unfollow').removeClass('bg-blue-600').addClass('bg-gray-600');
            } else {
                btn.text('Follow').removeClass('bg-gray-600').addClass('bg-blue-600');
            }

            btn.prop('disabled', false);
        });
    });

});
</script>
@endauth

@endsection