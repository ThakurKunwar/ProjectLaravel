<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Posts</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">




  <!-- Top Navigation -->
  <header class="w-full bg-white shadow-sm">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <h1 class="text-xl font-bold text-gray-800">{{ config('app.name') }}</h1>
      <div class="space-x-4">
        <a href="/login" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900 transition">Login To Post</a>
        <a href="/signup" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100 transition">Signup To Post</a>
      </div>
    </div>
  </header>

  <!-- Posts Grid -->
  <main class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">All Posts</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach($posts as $post)
        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col">
          
          <a href="/post/{{$post->id}}">
          @if($post->image)



          
            <img src="{{ Storage::url($post->image) }}" alt="Post Image" class="w-full h-40 object-cover">
          @endif
          </a>

          <div class="p-4 flex flex-col flex-1">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $post->title }}</h3>
            <p class="text-gray-600 text-sm flex-1">{{ Str::limit($post->description, 80) }}</p>
            <div class="mt-3 text-gray-500 text-xs">
              Posted by: 
              <a href="/profile/{{ optional($post->user)->id ?? '#' }}" class="hover:underline">
                {{ optional($post->user)->name ?? 'Unknown' }}
              </a>
            </div>
          </div>

        </div>
      @endforeach
    </div>
  </main>

</body>
</html>