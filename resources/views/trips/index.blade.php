<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xe của tôi - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-nav></x-nav>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Xe của tôi</h1>
            <a href="{{ url('/') }}" class="text-green-600 hover:text-green-700 font-medium">Về trang chủ</a>
        </div>

        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 flex items-center justify-between">
            <span class="font-semibold">Tổng tiền mỗi ngày (đang thuê)</span>
            <span class="text-xl font-bold">{{ number_format((int)$dailyTotal, 0, ',', '.') }}K</span>
        </div>

        @if($bookings->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl p-4">
                Bạn chưa có chuyến nào.
            </div>
        @else
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Đang thuê</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                @forelse ($ongoing as $booking)
                    <div class="bg-white rounded-xl border border-gray-200 p-3 group">
                        <a href="/car/{{ $booking->car->slug }}">
                            @php $first = is_array($booking->car->images) ? ($booking->car->images[0] ?? '') : $booking->car->images; @endphp
                            <img class="h-56 w-full object-cover rounded-lg" src="{{ \Illuminate\Support\Str::startsWith($first, ['http://','https://','//']) ? $first : asset('storage/'.$first) }}" alt="{{ $booking->car->model }}">
                            <div class="pt-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $booking->car->model }}</h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p><span class="font-medium">Thời gian:</span> {{ $booking->start_date }} → {{ $booking->end_date }}</p>
                                    <p><span class="font-medium">Giá mỗi ngày:</span> {{ number_format((int)$booking->daily_price, 0, ',', '.') }}K</p>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 11.5A2.5 2.5 0 0 1 9.5 9A2.5 2.5 0 0 1 12 6.5A2.5 2.5 0 0 1 14.5 9A2.5 2.5 0 0 1 12 11.5M12 2C15.87 2 19 5.13 19 9C19 14.25 12 22 12 22C12 22 5 14.25 5 9C5 5.13 8.13 2 12 2Z"></path>
                                    </svg>
                                    <span class="truncate">{{ $booking->car->address }}</span>
                                </div>
                                <form method="POST" action="/bookings/{{ $booking->id }}/cancel" class="mt-3">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-500 text-white font-medium py-2 rounded-lg hover:bg-red-600">Hủy chuyến</button>
                                </form>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl p-4">Không có chuyến đang thuê.</div>
                @endforelse
            </div>

            <h2 class="text-xl font-semibold text-gray-800 mb-4">Đã thuê</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($past as $booking)
                    <div class="bg-white rounded-xl border border-gray-200 p-3 group opacity-80">
                        <a href="/car/{{ $booking->car->slug }}">
                            @php $first = is_array($booking->car->images) ? ($booking->car->images[0] ?? '') : $booking->car->images; @endphp
                            <img class="h-56 w-full object-cover rounded-lg" src="{{ \Illuminate\Support\Str::startsWith($first, ['http://','https://','//']) ? $first : asset('storage/'.$first) }}" alt="{{ $booking->car->model }}">
                            <div class="pt-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $booking->car->model }}</h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p><span class="font-medium">Thời gian:</span> {{ $booking->start_date }} → {{ $booking->end_date }}</p>
                                    <p><span class="font-medium">Giá mỗi ngày:</span> {{ number_format((int)$booking->daily_price, 0, ',', '.') }}K</p>
                                    <p><span class="font-medium">Trạng thái:</span> {{ $booking->status === 'cancelled' ? 'Đã hủy' : 'Hoàn tất' }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl p-4">Chưa có chuyến đã thuê.</div>
                @endforelse
            </div>
        @endif
        <hr class="my-8 border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Xe của bạn đang cho thuê</h2>
        @if(isset($ownedCars) && $ownedCars->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($ownedCars as $car)
                    <div class="bg-white rounded-xl border border-gray-200 p-3 group">
                        <a href="/car/{{ $car->slug }}">
                            @php $first = is_array($car->images) ? ($car->images[0] ?? '') : $car->images; @endphp
                            <img class="h-56 w-full object-cover rounded-lg" src="{{ \Illuminate\Support\Str::startsWith($first, ['http://','https://','//']) ? $first : asset('storage/'.$first) }}" alt="{{ $car->model }}">
                            <div class="pt-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $car->model }}</h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p><span class="font-medium">Địa chỉ:</span> {{ $car->address }}</p>
                                    <p><span class="font-medium">Giá mỗi ngày:</span> {{ number_format((int)$car->price, 0, ',', '.') }}K</p>
                                </div>
                                <div class="mt-3 flex items-center space-x-2">
                                    <a href="/owner/cars/{{ $car->id }}/edit" class="inline-block flex-1 text-white font-medium py-2 rounded-lg text-center hover:opacity-90" style="background:#333">Sửa</a>
                                    <form method="POST" action="/owner/cars/{{ $car->id }}" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-white font-medium py-2 rounded-lg hover:opacity-90" style="background:#bc4749">Xóa</button>
                                    </form>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 border border-gray-200 text-gray-700 rounded-xl p-4">Bạn chưa có xe nào đang cho thuê.</div>
        @endif
    </section>

</body>
</html>
