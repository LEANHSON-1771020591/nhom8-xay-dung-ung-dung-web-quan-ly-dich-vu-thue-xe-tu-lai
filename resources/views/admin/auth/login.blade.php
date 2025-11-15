<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Đăng nhập - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
        <form method="POST" action="/admin/login" class="bg-white rounded-xl border border-gray-200 p-6 w-full max-w-md">
            @csrf
            <h1 class="text-2xl font-bold mb-4">Admin Đăng nhập</h1>
            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm text-gray-600 mb-1">Mật khẩu</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700">Đăng nhập</button>
            @if(session('error'))
                <div class="text-sm text-red-600 mt-3">{{ session('error') }}</div>
            @endif
            <p class="text-sm text-gray-600 mt-3">Chưa có tài khoản? <a class="text-green-600" href="/admin/register">Đăng ký Admin</a></p>
        </form>
    </div>
</body>
</html>

