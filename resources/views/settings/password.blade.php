@extends('layouts.dashboard')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">

    <h1 class="text-2xl font-bold mb-6 text-gray-800">
        🔐 Change Password
    </h1>

  

    <!-- ⚠️ VALIDATION ERRORS -->
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 🔐 FORM -->
    <form action="{{ route('settings.updatePassword', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- CURRENT PASSWORD -->
        <div>
            <label class="block text-gray-700 mb-1">Current Password</label>
            <input type="password" name="current_password"
                   placeholder="Enter current password"
                   class="border rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-gray-300">
        </div>

        <!-- NEW PASSWORD -->
        <div>
            <label class="block text-gray-700 mb-1">New Password</label>
            <input type="password" name="new_password"
                   placeholder="Enter new password"
                   class="border rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-gray-300">
        </div>

        <!-- CONFIRM PASSWORD -->
        <div>
            <label class="block text-gray-700 mb-1">Confirm New Password</label>
            <input type="password" name="new_password_confirmation"
                   placeholder="Confirm new password"
                   class="border rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-gray-300">
        </div>

        <!-- BUTTON -->
        <button type="submit"
            class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium 
                   hover:bg-black transition duration-200 shadow-sm">
            Update Password
        </button>

    </form>

    <!-- 🔗 FORGOT -->
    <div class="text-center mt-4">
        <a href="/forget-password" class="text-sm text-gray-500 hover:text-gray-800 hover:underline transition">
            Forgot your password?
        </a>
    </div>

</div>

@endsection