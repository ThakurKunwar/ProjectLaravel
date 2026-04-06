@extends('layouts.app')

@section('body')
<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-6">Forgot Password</h1>


    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ $errors->first() }}
    </div>
@endif

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

     @if(session('error'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if(auth()->check())
        <p class="mb-4">A reset link will be sent to your registered email: <strong>{{ $email }}</strong></p>
        <form action="/forget-password" method="POST">
            @csrf

            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">Send Reset Link</button>
        </form>
    @else
        <form action="/forget-password" method="POST" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" class="border p-2 w-full rounded" required>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">Send Reset Link</button>
        </form>
    @endif
</div>
@endsection