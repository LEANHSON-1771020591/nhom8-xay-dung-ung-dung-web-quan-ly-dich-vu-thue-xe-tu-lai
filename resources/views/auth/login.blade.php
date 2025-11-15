<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-nav></x-nav>
    <div class="max-w-md mx-auto mt-10 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/logos/logo.png') }}" alt="Logo" class="w-20 h-20 object-contain">
            <h1 class="mt-3 text-2xl font-bold text-gray-900">Đăng nhập</h1>
        </div>
        <form method="POST" action="/login" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-600 mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2" required value="{{ old('email') }}">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Mật khẩu</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700">Đăng nhập</button>
        </form>
        @if(session('error'))
            <div class="mt-3 text-sm text-red-600">{{ session('error') }}</div>
        @endif
    </div>
</body>
</html>

