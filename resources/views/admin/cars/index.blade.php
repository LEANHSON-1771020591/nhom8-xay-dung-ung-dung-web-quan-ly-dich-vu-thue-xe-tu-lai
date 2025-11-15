<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý Xe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-[#f5f7fb] overflow-x-hidden">
    <x-admin-nav></x-admin-nav>
    <section class="ml-64 w-[calc(100vw-16rem)] max-w-[calc(100vw-16rem)] px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Quản lý Xe</h1>
            <a href="/admin" class="text-green-600 hover:text-green-700 font-medium">Về Dashboard</a>
        </div>
        <div class="flex items-center justify-between mb-4">
            <a href="/admin/cars/create" class="inline-block bg-green-600 text-white font-medium px-4 py-2 rounded-lg hover:bg-green-700 inline-flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2h6Z"/></svg>
                <span>Tạo xe mới</span>
            </a>
        </div>
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 bg-white border border-gray-200 rounded-xl p-4 mb-6">
            
            <div>
                <label class="block text-sm text-gray-600 mb-1">Thành phố</label>
                <input type="text" name="location" value="{{ request('location') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="ho-chi-minh">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Chủ xe (ID)</label>
                <input type="number" name="owner" value="{{ request('owner') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="1">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Tên xe</label>
                <input type="text" name="model" value="{{ request('model') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Toyota...">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Giá tối thiểu (K)</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="0">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Giá tối đa (K)</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="500">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Truyền động</label>
                <select name="transmission" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tất cả</option>
                    <option value="AT" {{ request('transmission')==='AT' ? 'selected' : '' }}>AT</option>
                    <option value="MT" {{ request('transmission')==='MT' ? 'selected' : '' }}>MT</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Số ghế</label>
                <select name="seat" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tất cả</option>
                    <option value="4" {{ request('seat')==='4' ? 'selected' : '' }}>4</option>
                    <option value="5" {{ request('seat')==='5' ? 'selected' : '' }}>5</option>
                    <option value="7" {{ request('seat')==='7' ? 'selected' : '' }}>7</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nhiên liệu</label>
                <select name="fuel" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tất cả</option>
                    <option value="Xăng" {{ request('fuel')==='Xăng' ? 'selected' : '' }}>Xăng</option>
                    <option value="Dầu" {{ request('fuel')==='Dầu' ? 'selected' : '' }}>Dầu</option>
                    <option value="Điện" {{ request('fuel')==='Điện' ? 'selected' : '' }}>Điện</option>
                </select>
            </div>
            <div class="flex items-end space-x-3">
                <button type="submit" class="w-full bg-green-500 text-white font-medium py-2 rounded-lg hover:bg-green-600">Lọc</button>
                <a href="/admin/cars" class="w-full bg-gray-100 text-gray-700 font-medium py-2 rounded-lg hover:bg-gray-200 text-center">Hủy lọc</a>
            </div>
        </form>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <table class="min-w-full table-fixed">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Ảnh</th>
                        <th class="px-4 py-2 text-left">Model</th>
                        <th class="px-4 py-2 text-left">Thành phố</th>
                        <th class="px-4 py-2 text-left">Chủ xe</th>
                        <th class="px-4 py-2 text-left">Giá</th>
                        <th class="px-4 py-2 text-left">Trạng thái</th>
                        <th class="px-4 py-2 text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2">
                            @php($first = is_array($car->images) ? ($car->images[0] ?? '') : $car->images)
                            <img class="h-12 w-20 object-cover rounded ring-1 ring-gray-200" src="{{ \Illuminate\Support\Str::startsWith($first, ['http://','https://','//']) ? $first : asset('storage/'.$first) }}" alt="{{ $car->model }}">
                        </td>
                        <td class="px-4 py-2">{{ $car->model }}</td>
                        <td class="px-4 py-2">{{ $car->location }}</td>
                        <td class="px-4 py-2">{{ $car->owner_id }}</td>
                        <td class="px-4 py-2">{{ number_format((int)$car->price, 0, ',', '.') }}K</td>
                        <td class="px-4 py-2">
                            @php($color = $car->status==='approved' ? 'bg-green-100 text-green-700' : ($car->status==='pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'))
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $color }}">{{ $car->status }}</span>
                        </td>
                        <td class="px-4 py-2">
                            <a href="/admin/cars/{{ $car->id }}/edit" class="px-3 py-1 rounded bg-blue-500 text-white text-sm inline-flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25Zm18-11.5a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75L21 5.75Z"/></svg>
                                <span>Sửa</span>
                            </a>
                            <form method="POST" action="/admin/cars/{{ $car->id }}" class="inline ml-2" onsubmit="return confirm('Xóa xe này?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 rounded bg-red-500 text-white text-sm inline-flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M6 7h12v2H6V7Zm2 14h8a2 2 0 0 0 2-2V9H6v10a2 2 0 0 0 2 2Zm3-8h2v6h-2v-6Zm-1-9h4l1 2h-6l1-2Z"/></svg>
                                    <span>Xóa</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-600">Không có xe phù hợp</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
