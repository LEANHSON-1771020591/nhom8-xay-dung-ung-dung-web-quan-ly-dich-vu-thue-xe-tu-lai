<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }} - Vato Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-50">
    <x-nav></x-nav>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ url('/') }}" class="text-green-600 hover:text-green-700 font-medium">Về trang chủ</a>
        <h1 class="mt-3 text-3xl font-bold text-gray-900">{{ $blog->title }}</h1>
        @php($src = \Illuminate\Support\Str::startsWith($blog->thumbnail, ['http://','https://','//']) ? $blog->thumbnail : asset('storage/'.$blog->thumbnail))
        <img src="{{ $src }}" alt="{{ $blog->title }}" class="mt-6 w-full h-[340px] object-cover rounded-2xl">
        <div class="mt-6 prose max-w-none">
            {!! $blog->content_html !!}
        </div>
    </div>
</body>
</html>