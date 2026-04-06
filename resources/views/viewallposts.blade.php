@extends('layouts.dashboard')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold text-gray-800">All Posts</h2>
</div>

<!-- POSTS -->
<x-posts-list :posts="$posts" />

@endsection