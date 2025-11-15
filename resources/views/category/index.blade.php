<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xe tại {{ ucwords(str_replace('-', ' ', $slug)) }} - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body>
    <x-nav></x-nav>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Xe tại {{ ucwords(str_replace('-', ' ', $slug)) }}</h1>
            <a href="/" class="text-green-600 hover:text-green-700 font-medium">Về trang chủ</a>
        </div>

        <form method="GET" action="/filter/{{ $slug }}" class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4 bg-white border border-gray-200 rounded-xl p-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">Giá tối thiểu (K)</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="0">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Giá tối đa (K)</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="500">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Tìm theo tên xe</label>
                <input type="text" name="model" value="{{ request('model') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Ví dụ: Toyota">
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
                <a href="/filter/{{ $slug }}" class="w-full bg-gray-100 text-gray-700 font-medium py-2 rounded-lg hover:bg-gray-200 text-center">Hủy lọc</a>
            </div>
        </form>

        @if($cars->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl p-4">
                Không có xe nào phù hợp tại khu vực này.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($cars as $car)
                    <div class="bg-white rounded-xl border border-gray-200 p-3 group transform hover:-translate-y-2 transition-transform duration-300">
                        <a href="/car/{{ $car->slug }}">
                            @php $first = is_array($car->images) ? ($car->images[0] ?? '') : $car->images; @endphp
                            @php $today = \Carbon\Carbon::today()->toDateString(); @endphp
                            @php $booked = \App\Models\Booking::activeOn($today)->where('car_id', $car->id)->exists(); @endphp
                            <div class="relative">
                                <img class="h-56 w-full object-cover rounded-lg" src="{{ \Illuminate\Support\Str::startsWith($first, ['http://','https://','//']) ? $first : asset('storage/'.$first) }}" alt="{{ $car->model }}">
                                @if($booked)
                                    <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-2 py-1 rounded">Đã thuê</span>
                                @endif
                            </div>
                            <div class="pt-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $car->model }}</h3>

                                <div class="mt-3 flex items-center space-x-4 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.532 1.532 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.532 1.532 0 01-.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $car->transmission }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $car->seat }} chỗ</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 mr-1 flex-shrink-0" fill="currentColor">
                                            <path d="M12 2.5C12 2.5 6 8.5 6 14.5C6 17.5376 8.46243 20 11.5 20H12.5C15.5376 20 18 17.5376 18 14.5C18 8.5 12 2.5 12 2.5Z"></path>
                                        </svg>
                                        <span>{{ $car->fuel }}</span>
                                    </div>
                                </div>

                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 11.5A2.5 2.5 0 0 1 9.5 9A2.5 2.5 0 0 1 12 6.5A2.5 2.5 0 0 1 14.5 9A2.5 2.5 0 0 1 12 11.5M12 2C15.87 2 19 5.13 19 9C19 14.25 12 22 12 22C12 22 5 14.25 5 9C5 5.13 8.13 2 12 2Z"></path>
                                    </svg>
                                    <span class="truncate">{{ $car->address }}</span>
                                </div>

                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4 mr-1 flex-shrink-0" fill="currentColor">
                                            <path d="M13 3H11V9H5V11H11V13H3V15H11V21H13V15H21V13H13V11H19V9H13V3Z"></path>
                                        </svg>
                                        <span>{{ $car->trip }} chuyến</span>
                                    </div>
                                    <p class="text-lg font-bold text-green-600">{{ number_format((int)$car->price, 0, ',', '.') }}K<span class="text-sm font-normal text-gray-500">/ngày</span></p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

</body>
</html>
