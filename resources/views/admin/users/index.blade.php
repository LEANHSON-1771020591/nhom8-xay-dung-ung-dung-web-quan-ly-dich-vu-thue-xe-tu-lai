<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Người dùng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-[#f5f7fb] overflow-x-hidden">
    <x-admin-nav></x-admin-nav>
    <section class="ml-64 w-[calc(100vw-16rem)] max-w-[calc(100vw-16rem)] px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Người dùng</h1>
            <a href="/admin" class="text-green-600 hover:text-green-700 font-medium">Về Dashboard</a>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <table class="min-w-full table-fixed">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Tên</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Vai trò</th>
                        <th class="px-4 py-2 text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $u->name }}</td>
                        <td class="px-4 py-2">{{ $u->email }}</td>
                        <td class="px-4 py-2">{{ $u->role }}</td>
                        <td class="px-4 py-2">
                            <form method="POST" action="/admin/users/{{ $u->id }}/lock" class="inline" onsubmit="return confirm('Xóa người dùng này? Hành động không thể hoàn tác.');">
                                @csrf
                                <button class="px-3 py-1 rounded bg-red-500 text-white text-sm inline-flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M6 7h12v2H6V7Zm2 14h8a2 2 0 0 0 2-2V9H6v10a2 2 0 0 0 2 2Zm3-8h2v6h-2v-6Zm-1-9h4l1 2h-6l1-2Z"/></svg>
                                    <span>Xóa</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-600">Không có người dùng</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
