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
        <a href="/post/{{ $post->id }}">
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 hover:shadow-lg transition">

            <!-- IMAGE -->
            @if($post->image)
                <img src="{{ Storage::url($post->image) }}"
                     class="w-full max-h-96 object-cover">
            @endif

            <!-- CONTENT -->
            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    {{ $post->title }}
                </h3>

                <p class="text-gray-600 text-sm mt-1">
                    {{ $post->description }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>

            <!-- COMMENTS PREVIEW -->
            @if($post->comments->count() > 0)
            <div class="px-4 py-2 border-t">
                <h4 class="text-sm font-semibold text-gray-700 mb-1">Comments:</h4>
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
            </div>
            @endif

        </div>
        </a>
    @empty
        <div class="bg-white p-6 rounded-xl shadow-md text-center text-gray-500">
            No posts yet.
        </div>
    @endforelse

</div>

@endsection