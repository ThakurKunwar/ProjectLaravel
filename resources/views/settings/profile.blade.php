@extends('layouts.dashboard')

@section('content')

<h2 class="text-2xl font-bold text-gray-800 mb-6">Profile Settings</h2>



<form action="/settings/{{auth()->id()}}/profile" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
<div class="bg-white p-6 rounded-xl shadow-md space-y-6">

    <!-- 👤 PROFILE PICTURE -->
    <div class="flex flex-col md:flex-row items-center gap-6">
        <div class="relative">
            <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : '/default-avatar.png' }}" 
                 alt="Profile Picture" 
                 class="w-28 h-28 rounded-full object-cover border border-gray-200">
            <label for="profile-picture" 
                   class="absolute bottom-0 right-0 bg-gray-800 text-white p-2 rounded-full cursor-pointer hover:bg-gray-900">
                ✏️
            </label>
            <input type="file" id="profile-picture" class="hidden" name="profile_picture" accept="image/*">
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-gray-800">Profile Picture</h3>
            <p class="text-gray-500 text-sm">Upload a clear profile picture so people can recognize you.</p>
        </div>
    </div>

<!-- 📝 CURRENT BIO DISPLAY -->
<div class="bg-gray-50 p-4 rounded-lg border">
    <h3 class="text-md font-semibold text-gray-800 mb-1">Your Bio</h3>
    
    @if(auth()->user()->bio)
        <p class="text-gray-700">{{ auth()->user()->bio }}</p>
    @else
        <p class="text-gray-400 italic">No bio added yet...</p>
    @endif
</div>

<!-- 📝 BIO EDIT -->
<div>
    <label class="block text-gray-700 font-medium mb-2">Edit Bio</label>
    <textarea name="bio" rows="3"
        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
        placeholder="Tell us about yourself...">{{ auth()->user()->bio }}</textarea>
</div>

    <!-- 🌐 USEFUL INFO -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-medium mb-2">Location</label>
            <input type="text" name="location" value="{{ auth()->user()->location }}" 
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Your city or country">
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Website</label>
            <input type="url" name="website" value="{{ auth()->user()->website }}" 
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="https://example.com">
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Birthday</label>
            <input type="date" name="birthday" value="{{ auth()->user()->birthday }}" 
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" 
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
    </div>

    <!-- 💾 SAVE BUTTON -->
    <div class="flex justify-end">
        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            💾 Save Changes
        </button>
    </div>

</div>
</form>
@endsection