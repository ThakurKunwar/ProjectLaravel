@if(auth()->user())
<div class="bg-white p-5 rounded-xl shadow-md">

    <h3 class="font-semibold text-gray-800 mb-4">Menu</h3>

    <ul class="space-y-3 text-gray-600">

        <li>
            <a href="/home"
               class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->is('home') ? 'bg-gray-200 font-semibold' : '' }}">
                🏠 Home
            </a>
        </li>

        <li>
            <a href="/allposts"
               class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->is('allposts*') ? 'bg-gray-200 font-semibold' : '' }}">
                📖 All Post
            </a>
        </li>

        <li>
            <a href="/profile/{{ auth()->user()->id }}"
               class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->is('profile*') ? 'bg-gray-200 font-semibold' : '' }}">
                👤 Profile
            </a>
        </li>

        <li>
            <a href="/settings/{{ auth()->user()->id }}"
               class="block px-3 py-2 rounded-lg hover:bg-gray-100 {{ request()->is('settings*') ? 'bg-gray-200 font-semibold' : '' }}">
                ⚙️ Settings
            </a>
        </li>

    </ul>

</div>
@endif