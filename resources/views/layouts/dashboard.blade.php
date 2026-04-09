
@extends('layouts.app')

@section('body')

<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- LEFT SIDEBAR -->
        <aside class="hidden lg:block col-span-1">
            @include('partials.sidebar')
        </aside>

        <!-- MAIN CONTENT -->
        <main class="lg:col-span-2 space-y-6">
            @yield('content')
        </main>

    @if(auth()->user())
<!-- RIGHT SIDEBAR -->
<aside class="hidden lg:block col-span-1 space-y-6">

    <div class="bg-white p-5 rounded-xl shadow-md text-center">
        <!-- Profile Picture -->
        <div class="w-16 h-16 mx-auto mb-3 rounded-full overflow-hidden border border-gray-200">
            <img src="{{ auth()->user()->profile_picture 
                        ? Storage::url(auth()->user()->profile_picture) 
                        : '/default-avatar.png' }}" 
                 alt="Profile Picture" 
                 class="w-full h-full object-cover">
        </div>

        <!-- Name -->
        <h3 class="font-semibold text-gray-800">
            {{ auth()->user()->name }}
        </h3>
        <p class="text-sm text-gray-500">Welcome back 👋</p>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-md">
        <h3 class="font-semibold text-gray-800 mb-3">Your Stats</h3>
        <p class="text-sm text-gray-600">Posts: {{ auth()->user()->posts->count() }}</p>
        <p class="text-sm text-gray-600">Followers: {{ auth()->user()->followers()->count() }}</p>
        <p class="text-sm text-gray-600">Following: {{ auth()->user()->following()->count() }}</p>
    </div>

</aside>
@endif

    </div>

</div>

@endsection
