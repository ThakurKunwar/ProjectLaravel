<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gray-50 flex flex-col items-center justify-center">

    <!-- Project Name (Outside Card) -->
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
        {{ config('app.name') }}
    </h1>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-md p-6 w-full max-w-md flex flex-col gap-4">

        <!-- Heading (Login / Signup) -->
        <h2 class="text-2xl font-semibold text-gray-800 text-center">
            @yield('heading')
        </h2>

        <!-- SESSION MESSAGES ONLY -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 text-sm p-3 rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 text-sm p-3 rounded text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Page Content (Form) -->
        <div class="flex flex-col gap-3">
            @yield('content')
        </div>

    </div>

</body>
</html>