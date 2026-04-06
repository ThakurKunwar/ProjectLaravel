@extends('layouts.auth')

@section('title', 'Login')
@section('heading', 'Login')

@section('content')

<form method="POST" action="/login" class="space-y-5">
    @csrf

    <!-- Email -->
    <div>
        <label class="block text-gray-600 mb-1">Email</label>
        <input 
            type="text" 
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

    <!-- Forgot Password Link -->
<p class="text-right text-sm text-gray-500 mb-2">
    <a href="/forget-password" class="hover:underline text-gray-800">Forgot Password?</a>
</p>

    <button class="w-full bg-gray-800 hover:bg-gray-900 text-white py-2 rounded-md transition">
        Login
    </button>
</form>

<p class="text-center text-gray-600 mt-4">
    Create an account?
    <a href="/signup" class="text-gray-800 hover:underline">Signup</a>
</p>

@endsection