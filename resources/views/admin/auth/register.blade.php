<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Đăng ký - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
        <form method="POST" action="/admin/register" class="bg-white rounded-xl border border-gray-200 p-6 w-full max-w-md">
            @csrf
            <h1 class="text-2xl font-bold mb-4">Admin Đăng ký</h1>
            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Tên hiển thị</label>
                <input type="text" name="username" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Mật khẩu</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700">Đăng ký</button>
        </form>
    </div>
</body>
</html>

