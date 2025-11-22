<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Blog - Vato Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f7fb] overflow-x-hidden">
    <x-admin-nav></x-admin-nav>
    <section class="ml-64 w-[calc(100vw-16rem)] max-w-[calc(100vw-16rem)] px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Quản lý Blog</h1>
            <div class="flex gap-2">
                <a href="{{ url('/admin/blogs/create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">Thêm bài viết</a>
            </div>
        </div>
        @if(session('success'))
            <div class="mb-3 px-4 py-2 bg-green-50 text-green-700 border border-green-200 rounded">{{ session('success') }}</div>
        @endif
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Tiêu đề</th>
                        <th class="p-3 text-left">Thumbnail</th>
                        <th class="p-3 text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $b)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $b->id }}</td>
                        <td class="p-3 truncate max-w-[420px]">{{ $b->title }}</td>
                        @php($src = \Illuminate\Support\Str::startsWith($b->thumbnail, ['http://','https://','//']) ? $b->thumbnail : asset('storage/'.$b->thumbnail))
                        <td class="p-3"><img src="{{ $src }}" alt="thumb" class="w-24 h-14 object-cover rounded"></td>
                        <td class="p-3"><a class="text-blue-600" href="{{ url('/blog/'.$b->id) }}">Xem</a></td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <a href="{{ url('/admin/blogs/'.$b->id.'/edit') }}" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded">Sửa</a>
                                <form method="POST" action="{{ url('/admin/blogs/'.$b->id) }}" onsubmit="return confirm('Xóa bài viết?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $blogs->links() }}</div>
    </section>
</body>
</html>