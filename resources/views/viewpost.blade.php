@extends('layouts.dashboard')

@section('content')

<div class="max-w-3xl mx-auto mt-6">

    <!-- POST HEADER -->
    <div class="flex items-center gap-3 mb-4">
        <div class="w-12 h-12 bg-gray-300 rounded-full"></div>
        <div>
            <p class="font-semibold text-gray-800">{{ optional($post->user)->name ?? 'Unknown' }}</p>
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

    <!-- ACTIONS -->
    <div class="flex justify-between items-center text-gray-500 mb-6">
        <div class="flex gap-4">
            <button class="hover:text-black transition">❤️ Like</button>
            <button class="hover:text-black transition">💬 Comment</button>
            <button class="hover:text-black transition">🔗 Share</button>
        </div>
        @can('delete', $post)
        <form action="/delete-post/{{$post->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="hover:text-red-600 transition">🗑 Delete</button>
        </form>
        @endcan
    </div>

    <!-- ALL COMMENTS -->
    <div class="bg-white p-4 rounded-xl shadow-md mb-6">
        <h3 class="font-semibold mb-3 text-gray-800">Comments ({{ $post->comments->count() }})</h3>

        @forelse($post->comments as $comment)
            <div class="mb-2">
                <p class="text-sm">
                    <strong>
                        @if(auth()->id() === $comment->user->id)
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

    <!-- COMMENT FORM -->
    @if(auth()->check())
    <div class="bg-white p-4 rounded-xl shadow-md">
        @include('components.comment-form', ['post' => $post])
    </div>
    @endif

</div>

@endsection