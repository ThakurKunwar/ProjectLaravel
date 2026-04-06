@extends('layouts.dashboard')

@section('content')

<div class="max-w-xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">✏️ Change Username</h2>
        <a href="/settings/{{ $user->id }}/password"
           class="text-sm text-gray-500 hover:text-gray-800 hover:underline transition">
            Change Password
        </a>
    </div>

    <!-- SUCCESS / ERROR MESSAGES -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- CARD -->
    <div class="bg-white p-6 rounded-xl shadow-md">

        <!-- CURRENT USERNAME -->
        <p class="mb-4 text-gray-600">
            Current Username: <span class="font-semibold">{{ auth()->user()->name }}</span>
        </p>

        <!-- CHANGE USERNAME FORM -->
        <form action="{{ url('/settings/' . $user->id . '/editUser') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 mb-1">New Username</label>
                <input type="text" name="username" placeholder="Enter new username"
                       class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-gray-300"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium 
                           hover:bg-black transition duration-200 shadow-sm">
                Update Username
            </button>
        </form>

        <p class="mt-4 text-sm text-gray-500">
            Note: You can only change your username once every 24 hours.
        </p>
    </div>

</div>

@endsection