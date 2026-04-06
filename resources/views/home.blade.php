@extends('layouts.dashboard')

@section('content')

<!-- CREATE POST FORM -->
<div class="bg-white p-4 rounded-xl shadow-md mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-2">Create a Post</h3>
    <form action="/create-post" method="POST" enctype="multipart/form-data" class="space-y-2">
        @csrf
        <input type="text" name="title" placeholder="Post Title" class="border rounded p-1 w-full text-sm">
        <textarea name="description" placeholder="Write something..." class="border rounded p-1 w-full text-sm" rows="3"></textarea>
        <input type="file" name="image" class="border rounded p-1 w-full text-sm">
        <button class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Publish</button>
    </form>
</div>

<!-- POSTS -->
<x-posts-list :posts="$posts" />

@endsection