@extends('layouts.dashboard')

@section('content')

<h2 class="text-2xl font-bold text-gray-800 mb-6">Settings</h2>

<div class="bg-white p-6 rounded-xl shadow-md space-y-4">

    <a href="/settings/{{auth()->user()->id}}/profile" class="block p-3 border rounded-lg hover:bg-gray-50">
        🖼️ Change Profile
    </a>

    <a href="/settings/{{auth()->user()->id}}/password" class="block p-3 border rounded-lg hover:bg-gray-50">
        🔑 Change Password
    </a>

    <a href="/settings/{{auth()->user()->id}}/editUser" class="block p-3 border rounded-lg hover:bg-gray-50">
        🧑 Change Username
    </a>

</div>

@endsection