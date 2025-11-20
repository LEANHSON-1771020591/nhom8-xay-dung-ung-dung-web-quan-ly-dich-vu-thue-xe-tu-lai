<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-[#f5f7fb] overflow-x-hidden">
    <x-admin-nav></x-admin-nav>
    <section class="ml-64 w-[calc(100vw-16rem)] max-w-[calc(100vw-16rem)] px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <a href="{{ url('/') }}" class="text-green-600 hover:text-green-700 font-medium">Về trang chủ</a>
        </div>
        <p class="text-gray-600 mb-8">Theo dõi hiệu suất hệ thống, quản lý xe, người dùng và đặt xe từ một nơi.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-green-600" fill="currentColor"><path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4ZM4 20a6 6 0 0 1 12 0H4Z"/></svg>
                    <p>Tổng người dùng</p>
                </div>
                <p class="mt-2 text-3xl font-bold">{{ $usersCount }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-blue-600" fill="currentColor"><path d="M3 16a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v3h-2v-1H5v1H3v-3Zm4-7 2-3h6l2 3H7Z"/></svg>
                    <p>Tổng số xe</p>
                </div>
                <p class="mt-2 text-3xl font-bold">{{ $carsCount }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-purple-600" fill="currentColor"><path d="M6 2h12v4H6V2Zm-2 6h16v14H4V8Zm4 3h8v2H8v-2Zm0 4h8v2H8v-2Z"/></svg>
                    <p>Tổng booking</p>
                </div>
                <p class="mt-2 text-3xl font-bold">{{ $bookingsCount }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-green-600" fill="currentColor"><path d="M12 7v5h5v2h-7V7h2Zm0-5a10 10 0 1 0 10 10A10 10 0 0 0 12 2Z"/></svg>
                    <p>Booking hôm nay</p>
                </div>
                <p class="mt-2 text-2xl font-bold">{{ $dailyBookings }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-indigo-600" fill="currentColor"><path d="M19 3H5a2 2 0 0 0-2 2v14l4-4h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
                    <p>Booking tuần này</p>
                </div>
                <p class="mt-2 text-2xl font-bold">{{ $weeklyBookings }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-pink-600" fill="currentColor"><path d="M3 4h18v2H3V4Zm0 6h18v2H3v-2Zm0 6h18v2H3v-2Z"/></svg>
                    <p>Booking tháng này</p>
                </div>
                <p class="mt-2 text-2xl font-bold">{{ $monthlyBookings }}</p>
            </div>
        </div>
        <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-3">Booking gần đây</h2>
                <table class="min-w-full table-fixed">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-3 py-2 text-left">Xe</th>
                            <th class="px-3 py-2 text-left">Khách</th>
                            <th class="px-3 py-2 text-left">Thời gian</th>
                            <th class="px-3 py-2 text-left">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(($recentBookings ?? []) as $b)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-3 py-2">{{ $b->car->model }}</td>
                            <td class="px-3 py-2">{{ $b->user->name }}</td>
                            <td class="px-3 py-2">{{ $b->start_date }} → {{ $b->end_date }}</td>
                            <td class="px-3 py-2">{{ $b->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-3">Người dùng tích cực</h2>
                <table class="min-w-full table-fixed">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-3 py-2 text-left">Tên</th>
                            <th class="px-3 py-2 text-left">Booking 30 ngày</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(($activeUsers ?? []) as $u)
                        <tr class="border-t">
                            <td class="px-3 py-2">{{ $u->name }}</td>
                            <td class="px-3 py-2">{{ $u->recent_bookings_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-10 bg-white border border-gray-200 rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-3">Chủ xe tích cực</h2>
            <table class="min-w-full table-fixed">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left">Tên</th>
                        <th class="px-3 py-2 text-left">Số xe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(($topOwners ?? []) as $o)
                    <tr class="border-t">
                        <td class="px-3 py-2">{{ $o->name }}</td>
                        <td class="px-3 py-2">{{ $o->cars_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
