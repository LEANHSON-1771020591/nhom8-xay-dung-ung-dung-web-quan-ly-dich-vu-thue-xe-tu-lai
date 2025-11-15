<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo xe - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-[#f5f7fb] overflow-x-hidden">
    <x-admin-nav></x-admin-nav>
    <section class="ml-64 max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Tạo xe mới</h1>
            <a href="/admin/cars" class="text-green-600 hover:text-green-700 font-medium">Về danh sách xe</a>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            <form method="POST" action="/admin/cars" enctype="multipart/form-data" class="grid grid-cols-1 gap-4">
                @csrf
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Model</label>
                    <input type="text" name="model" value="{{ old('model') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Địa chỉ</label>
                        <input type="text" name="address" value="{{ old('address') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Thành phố (slug)</label>
                        <select name="location" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="ho-chi-minh" {{ old('location')==='ho-chi-minh' ? 'selected' : '' }}>Ho Chi Minh</option>
                            <option value="ha-noi" {{ old('location')==='ha-noi' ? 'selected' : '' }}>Ha Noi</option>
                            <option value="da-nang" {{ old('location')==='da-nang' ? 'selected' : '' }}>Da Nang</option>
                            <option value="thanh-hoa" {{ old('location')==='thanh-hoa' ? 'selected' : '' }}>Thanh Hoa</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Giá (K/ngày)</label>
                        <input type="number" name="price" min="1" value="{{ old('price') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Số ghế (>=4)</label>
                        <input type="number" name="seat" min="4" value="{{ old('seat') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Truyền động</label>
                        <select name="transmission" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="AT" {{ old('transmission')==='AT' ? 'selected' : '' }}>AT</option>
                            <option value="MT" {{ old('transmission')==='MT' ? 'selected' : '' }}>MT</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nhiên liệu</label>
                        <select name="fuel" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            <option value="Xăng" {{ old('fuel')==='Xăng' ? 'selected' : '' }}>Xăng</option>
                            <option value="Dầu" {{ old('fuel')==='Dầu' ? 'selected' : '' }}>Dầu</option>
                            <option value="Điện" {{ old('fuel')==='Điện' ? 'selected' : '' }}>Điện</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Chủ xe (User ID)</label>
                        <input type="number" name="owner_id" value="{{ old('owner_id') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Hình ảnh xe (bắt buộc 4 ảnh)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="file" name="images[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        <input type="file" name="images[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        <input type="file" name="images[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        <input type="file" name="images[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Mô tả</label>
                    <textarea name="desc" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>{{ old('desc') }}</textarea>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg hover:bg-green-700">Tạo xe</button>
            </form>
        </div>
    </section>
</body>
</html>
