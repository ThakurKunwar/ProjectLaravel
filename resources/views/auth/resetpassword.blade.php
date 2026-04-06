@extends('layouts.auth') {{-- assuming your file is saved as layouts/auth.blade.php --}}

@section('title', 'Reset Password')
@section('heading', 'Reset Your Password')

@section('content')
<form method="POST" action="/update-password" class="flex flex-col gap-4">
    @csrf

    <!-- Hidden fields to pass email and token -->
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="token" value="{{ $token }}">

    <!-- New Password -->
    <div>
        <label class="block text-gray-700 mb-1">New Password</label>
        <input type="password" name="password" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        @error('password')
        <span style="color:red">*{{$message}}</span>
            @enderror
    </div>

    <!-- Confirm Password -->
    <div>
        <label class="block text-gray-700 mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
         @error('password_confirmation')
        <span style="color:red">*{{$message}}</span>
            @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 mt-2">
        Reset Password
    </button>
</form>
<a href="/login">Login</a>
@endsection