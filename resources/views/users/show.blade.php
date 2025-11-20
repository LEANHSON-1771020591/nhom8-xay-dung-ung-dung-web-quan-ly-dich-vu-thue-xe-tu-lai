<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">
    <x-nav></x-nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-end mb-4">
            <a href="{{ url('/') }}" class="text-green-600 hover:text-green-700 font-medium">Về trang chủ</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-start gap-6">
                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <div class="mt-2 text-sm text-gray-600">
                        <p class="text-green-600">{{ $trips }} chuyến</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách xe</h2>
            </div>
            <div class="mt-4 grid grid-cols-1 gap-6 justify-items-start">
                @forelse($cars as $car)
                    <a href="{{ url('/car/'.$car->slug) }}" class="flex flex-col border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white w-1/4 min-w-[280px]">
                        @php $src0 = is_array($car->images) ? ($car->images[0] ?? '') : $car->images; @endphp
                        <img src="{{ \Illuminate\Support\Str::startsWith($src0, ['http://','https://','//']) ? $src0 : asset('storage/'.$src0) }}" alt="{{ $car->model }}" class="w-full h-[240px] object-cover">
                        <div class="p-4 space-y-1">
                            <p class="text-xs text-gray-500">{{ ucfirst($car->fuel) }} • {{ $car->seat }} chỗ</p>
                            <p class="mt-2 text-sm font-semibold text-gray-900">{{ strtoupper($car->transmission) }} • {{ $car->address }}</p>
                            <p class="mt-3 text-green-600 font-bold">{{ number_format((int)$car->price,0,',','.') }}K/ngày</p>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-600">Thuê xe thôi</p>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>