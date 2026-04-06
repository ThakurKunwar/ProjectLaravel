@extends('layouts.auth')

@section('title', 'Signup')
@section('heading', 'Create Account')

@section('content')

<form method="POST" action="/signup" class="space-y-5">
    @csrf

    <!-- Name -->
    <div>
        <label class="block text-gray-600 mb-1">Name</label>
        <input 
            type="text" 
            name="name"
            value="{{ old('name') }}"
            placeholder="john doe"
            class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-gray-300
                   @error('name') border-red-500 @enderror"
        >
        @error('name')
            <span class="text-red-500 text-sm mt-1 block">*{{ $message }}</span>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label class="block text-gray-600 mb-1">Email</label>
        <input 
            type="email" 
            name="email"
            value="{{ old('email') }}"
            placeholder="example@gmail.com"
            class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-gray-300
                   @error('email') border-red-500 @enderror"
        >
        @error('email')
            <span class="text-red-500 text-sm mt-1 block">*{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label class="block text-gray-600 mb-1">Password</label>
        <input 
            type="password" 
            name="password"
            class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-gray-300
                   @error('password') border-red-500 @enderror"
        >
        @error('password')
            <span class="text-red-500 text-sm mt-1 block">*{{ $message }}</span>
        @enderror
    </div>

    <button class="w-full bg-gray-800 hover:bg-gray-900 text-white py-2 rounded-md transition">
        Signup
    </button>
</form>

<p class="text-center text-gray-600 mt-4">
    Already have an account?
    <a href="/login" class="text-gray-800 hover:underline">Login</a>
</p>

@endsection