<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">

        <!-- LEFT -->
        @if(auth()->user())
            <a href='/home'><h1 class="text-lg font-bold">{{ config('app.name') }}</h1></a>
        @else
            <a href="/"><h1 class="text-lg font-bold">{{ config('app.name') }}</h1></a>
        @endif

        <!-- CENTER (Search) -->
        <div class="flex-1 px-6">
            <input type="text" placeholder="Search..."
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-300">
        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-4">
            @if(auth()->user())
                <span>{{ auth()->user()->name }}</span>
                <form action="/logout" method="POST">
                    @csrf
                    @method('GET')
                    <button class="bg-gray-800 text-white px-4 py-2 rounded-lg">
                        Logout
                    </button>
                </form>
            @else
                <div class="space-x-4">
                    <a href="/login" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 transition">Login to Post</a>
                    <a href="/signup" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100 transition">Signup to Post</a>
                </div>
            @endif
        </div>
    </div>
</header>

<!-- FLASH MESSAGES (below navbar) -->
<div class="fixed top-16 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-2 shadow"
             x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 4000)">
            {{ session('success') }}
            <span class="float-right cursor-pointer" @click="show = false">✖</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-2 shadow"
             x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 4000)">
            {{ session('error') }}
            <span class="float-right cursor-pointer" @click="show = false">✖</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-2 shadow"
             x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 5000)">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <span class="float-right cursor-pointer" @click="show = false">✖</span>
        </div>
    @endif
</div>

<!-- AlpineJS (required for x-data, x-show) -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>