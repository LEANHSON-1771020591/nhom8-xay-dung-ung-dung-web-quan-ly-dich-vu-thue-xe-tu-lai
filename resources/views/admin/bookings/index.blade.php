<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-[#f5f7fb] overflow-x-hidden">
    <x-admin-nav></x-admin-nav>
    <section class="ml-64 w-[calc(100vw-16rem)] max-w-[calc(100vw-16rem)] px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Booking</h1>
            <a href="{{ url('/admin') }}" class="text-green-600 hover:text-green-700 font-medium">Về Dashboard</a>
        </div>
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 bg-white border border-gray-200 rounded-xl p-4 mb-6">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Trạng thái</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tất cả</option>
                    <option value="confirmed" {{ request('status')==='confirmed' ? 'selected' : '' }}>confirmed</option>
                    <option value="cancelled" {{ request('status')==='cancelled' ? 'selected' : '' }}>cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Từ ngày</label>
                <input type="date" name="from" value="{{ request('from') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Đến ngày</label>
                <input type="date" name="to" value="{{ request('to') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="flex items-end space-x-3">
                <button type="submit" class="w-full bg-green-500 text-white font-medium py-2 rounded-lg hover:bg-green-600">Lọc</button>
                <a href="{{ url('/admin/bookings') }}" class="w-full bg-gray-100 text-gray-700 font-medium py-2 rounded-lg hover:bg-gray-200 text-center">Hủy lọc</a>
            </div>
        </form>
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <table class="min-w-full table-fixed">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Xe</th>
                        <th class="px-4 py-2 text-left">Ảnh xe</th>
                        <th class="px-4 py-2 text-left">Khách thuê</th>
                        <th class="px-4 py-2 text-left">Khoảng thời gian</th>
                        <th class="px-4 py-2 text-left">Giá/ngày</th>
                        <th class="px-4 py-2 text-left">Trạng thái</th>
                        <th class="px-4 py-2 text-left">Tạo lúc</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $b->id }}</td>
                        <td class="px-4 py-2"><a class="text-blue-600" href="/car/{{ $b->car->slug }}">{{ $b->car->model }}</a></td>
                        <td class="px-4 py-2">
                            @php($first = is_array($b->car->images) ? ($b->car->images[0] ?? '') : $b->car->images)
                            <img class="h-12 w-20 object-cover rounded ring-1 ring-gray-200" src="{{ \Illuminate\Support\Str::startsWith($first, ['http://','https://','//']) ? $first : asset('storage/'.$first) }}" alt="{{ $b->car->model }}">
                        </td>
                        <td class="px-4 py-2">{{ $b->user->name }}</td>
                        <td class="px-4 py-2">{{ $b->start_date }} → {{ $b->end_date }}</td>
                        <td class="px-4 py-2">{{ number_format((int)$b->daily_price, 0, ',', '.') }}K</td>
                        <td class="px-4 py-2">{{ $b->status }}</td>
                        <td class="px-4 py-2">{{ $b->created_at }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-600">Không có booking</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
