<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">

        <!-- LEFT -->
        @if(auth()->user())
    <a href='/home'>    <h1 class="text-lg font-bold">{{ config('app.name') }}</h1></a>
    @else
    <h1 class="text-lg font-bold">{{ config('app.name') }}</h1>
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