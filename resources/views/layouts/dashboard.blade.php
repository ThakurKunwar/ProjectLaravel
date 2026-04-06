
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
                <div class="w-16 h-16 bg-gray-300 rounded-full mx-auto mb-3"></div>
                <h3 class="font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </h3>
                <p class="text-sm text-gray-500">Welcome back 👋</p>
            </div>
            @endif

            
            @if(auth()->check())
            <div class="bg-white p-5 rounded-xl shadow-md">
                <h3 class="font-semibold text-gray-800 mb-3">Stats</h3>
                @if( !auth()->user())
                
                <p class="text-sm text-gray-600">Posts: {{ $posts->count() }}</p>
                @else
                <p class="text-sm text-gray-600">Posts: {{ auth()->user()->posts->count() }}</p>
                @endif
                <p class="text-sm text-gray-600">Followers: 0</p>
            </div>
            @endif

        </aside>

    </div>

</div>

@endsection
