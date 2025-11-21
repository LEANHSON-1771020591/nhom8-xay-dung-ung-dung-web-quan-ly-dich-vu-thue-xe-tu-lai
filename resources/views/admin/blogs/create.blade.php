<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Blog - Vato Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f7fb] overflow-x-hidden">
    <x-admin-nav></x-admin-nav>
    <section class="ml-64 w-[calc(100vw-16rem)] max-w-[calc(100vw-16rem)] px-6 lg:px-8 py-10">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Thêm bài Blog</h1>
        <form method="POST" action="{{ url('/admin/blogs') }}" class="bg-white border border-gray-200 rounded-xl p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm mb-1">Tiêu đề</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm mb-1">Link (tuỳ chọn)</label>
                <input type="url" name="link" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm mb-1">Thumbnail URL</label>
                <input type="text" name="thumbnail" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm mb-1">Nội dung tóm tắt</label>
                <textarea name="content_text_preview" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm mb-1">Nội dung HTML</label>
                <textarea name="content_html" class="w-full border rounded px-3 py-2 font-mono" rows="10" required></textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">Lưu</button>
                <a href="{{ url('/admin/blogs') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Huỷ</a>
            </div>
        </form>
    </section>
</body>
</html>