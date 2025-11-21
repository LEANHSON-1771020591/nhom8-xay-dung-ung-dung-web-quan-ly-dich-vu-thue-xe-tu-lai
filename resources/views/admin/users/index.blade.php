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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle toggle role form submissions
            document.querySelectorAll('.toggle-role-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const button = this.querySelector('button');
                    const userName = button.getAttribute('data-user-name');
                    const currentRole = button.getAttribute('data-current-role');
                    const newRole = currentRole === 'admin' ? 'User' : 'Admin';
                    
                    if (confirm(`Thay đổi vai trò của ${userName} thành ${newRole}?`)) {
                        this.submit();
                    }
                });
            });
        });
    </script>
    <section class="ml-64 w-[calc(100vw-16rem)] max-w-[calc(100vw-16rem)] px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Người dùng</h1>
            <a href="{{ url('/admin') }}" class="text-green-600 hover:text-green-700 font-medium">Về Dashboard</a>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <table class="min-w-full table-fixed">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Tên</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Vai trò</th>
                        <th class="px-4 py-2 text-left">Hành động</th>
                        <th class="px-4 py-2 text-left">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $u->name }}</td>
                        <td class="px-4 py-2">{{ $u->email }}</td>
                        <td class="px-4 py-2">{{ $u->role }}</td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ url('/admin/users/' . $u->id . '/edit') }}" 
                                   class="px-3 py-1 rounded bg-blue-500 text-white text-sm inline-flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
                                    <span>Sửa</span>
                                </a>
                                
                                <form method="POST" action="{{ url('/admin/users/' . $u->id . '/toggle-role') }}" class="inline toggle-role-form">
                                    @csrf
                                    <button type="submit" 
                                            class="px-3 py-1 rounded bg-yellow-500 text-white text-sm inline-flex items-center space-x-1"
                                            data-user-name="{{ $u->name }}"
                                            data-current-role="{{ $u->role }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M10.5 1.75a.75.75 0 0 0-1.5 0V3h-3v1.5h3v3h1.5v-3h3V3h-3V1.75Z"/><path d="M4.5 6.75a.75.75 0 0 0-1.5 0v1.5H1.5a.75.75 0 0 0 0 1.5h1.5v1.5a.75.75 0 0 0 1.5 0v-1.5h1.5a.75.75 0 0 0 0-1.5H4.5v-1.5Z"/><path fill-rule="evenodd" d="M9 8.25a.75.75 0 0 0-.75.75v10.5a.75.75 0 0 0 1.5 0V9a.75.75 0 0 0-.75-.75Zm6 .75a.75.75 0 0 1 1.5 0v10.5a.75.75 0 0 1-1.5 0V9Z" clip-rule="evenodd"/></svg>
                                        <span>{{ $u->role === 'admin' ? 'User' : 'Admin' }}</span>
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ url('/admin/users/' . $u->id . '/lock') }}" class="inline" onsubmit="return confirm('Khóa tài khoản {{ $u->name }}?')">
                                    @csrf
                                    <button class="px-3 py-1 rounded bg-red-500 text-white text-sm inline-flex items-center space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M6 7h12v2H6V7Zm2 14h8a2 2 0 0 0 2-2V9H6v10a2 2 0 0 0 2 2Zm3-8h2v6h-2v-6Zm-1-9h4l1 2h-6l1-2Z"/></svg>
                                        <span>Khóa</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            @if($u->is_locked)
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Khóa</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Hoạt động</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-600">Không có người dùng</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
