<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sửa người dùng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f5f7fb] overflow-x-hidden">
    <x-admin-nav></x-admin-nav>
    <section class="ml-64 w-[calc(100vw-16rem)] max-w-[calc(100vw-16rem)] px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Sửa thông tin người dùng</h1>
            <div class="flex space-x-4">
                <a href="{{ url('/admin/users') }}" class="text-green-600 hover:text-green-700 font-medium">Quay lại</a>
                <a href="{{ url('/admin') }}" class="text-green-600 hover:text-green-700 font-medium">Về Dashboard</a>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/admin/users/' . $user->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tên người dùng</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Avatar URL</label>
                        <input type="url" name="avatar" id="avatar" value="{{ old('avatar', $user->avatar) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Vai trò</label>
                        <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="is_locked" value="1" {{ old('is_locked', $user->is_locked) ? 'checked' : '' }}
                                   class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="text-sm font-medium text-gray-700">Khóa tài khoản</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ url('/admin/users') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Hủy
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Hành động nhanh</h2>
            <div class="flex flex-wrap gap-4">
                <form method="POST" action="{{ url('/admin/users/' . $user->id . '/toggle-role') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                            onclick="return confirm('Bạn có chắc muốn thay đổi vai trò của {{ $user->name }} thành {{ $user->role === 'admin' ? 'User' : 'Admin' }}?')">
                        {{ $user->role === 'admin' ? 'Chuyển thành User' : 'Chuyển thành Admin' }}
                    </button>
                </form>

                <form method="POST" action="{{ url('/admin/users/' . $user->id . '/lock') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                            onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">
                        Khóa tài khoản
                    </button>
                </form>
            </div>
        </div>

        <!-- User Info Summary -->
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-xl p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Thông tin tóm tắt</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">ID:</span>
                    <span class="font-medium">{{ $user->id }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Ngày tạo:</span>
                    <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Số xe:</span>
                    <span class="font-medium">{{ $user->cars()->count() }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Số chuyến:</span>
                    <span class="font-medium">{{ $user->bookings()->count() }}</span>
                </div>
            </div>
        </div>
    </section>
</body>
</html>