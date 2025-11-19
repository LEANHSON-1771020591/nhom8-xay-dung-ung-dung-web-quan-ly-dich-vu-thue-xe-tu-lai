<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $car->model }} - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <x-nav></x-nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-end mb-4">
            <a href="{{ url('/') }}" class="text-green-600 hover:text-green-700 font-medium">Về trang chủ</a>
        </div>
        <div class="my-4 grid grid-cols-[2fr_1fr] grid-rows-3 gap-2 h-[586px]">
            <div class="row-span-3">
                @php $src0 = is_array($car->images) ? ($car->images[0] ?? '') : $car->images; @endphp
                <img src="{{ \Illuminate\Support\Str::startsWith($src0, ['http://','https://','//']) ? $src0 : asset('storage/'.$src0) }}" alt="Main car view" class="w-full h-full object-cover rounded-2xl">
            </div>
            <div>
                @php $src1 = is_array($car->images) ? ($car->images[1] ?? $src0) : $car->images; @endphp
                <img src="{{ \Illuminate\Support\Str::startsWith($src1, ['http://','https://','//']) ? $src1 : asset('storage/'.$src1) }}" alt="Car interior" class="w-full h-full object-cover rounded-2xl">
            </div>
            <div>
                @php $src2 = is_array($car->images) ? ($car->images[2] ?? $src0) : $car->images; @endphp
                <img src="{{ \Illuminate\Support\Str::startsWith($src2, ['http://','https://','//']) ? $src2 : asset('storage/'.$src2) }}" alt="Car side view" class="w-full h-full object-cover rounded-2xl">
            </div>
            <div>
                @php $src3 = is_array($car->images) ? ($car->images[3] ?? $src0) : $car->images; @endphp
                <img src="{{ \Illuminate\Support\Str::startsWith($src3, ['http://','https://','//']) ? $src3 : asset('storage/'.$src3) }}" alt="Car front view" class="w-full h-full object-cover rounded-2xl">
            </div>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-3 ">
            <div class="col-span-2">
                <h1 class="text-3xl font-bold text-gray-900">{{ $car->model }}</h1>
                <p class="mt-2 text-gray-500"><span>{{ $car->trip }}</span> • <span>{{ $car->address }}</span></p>
                <hr class="my-6 border-gray-200">

                <div class="my-6">
                    <p class="text-xl font-semibold text-gray-800">Đặc điểm</p>
                    <div class="mt-6 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="text-orange-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.532 1.532 0 012.287-.947c1.372.836 2.942-.734-2.106-2.106a1.532 1.532 0 01-.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Truyền động</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $car->transmission }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-orange-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Số ghế</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $car->seat }} chỗ</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-orange-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-8 w-8" fill="currentColor">
                                    <path d="M12 2.5C12 2.5 6 8.5 6 14.5C6 17.5376 8.46243 20 11.5 20H12.5C15.5376 20 18 17.5376 18 14.5C18 8.5 12 2.5 12 2.5Z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nhiên liệu</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $car->fuel }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-orange-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                    <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 0 1 .359.852L12.982 9.75h3.268a.75.75 0 0 1 .565 1.263l-8.25 11.25a.75.75 0 0 1-1.282-.577l1.992-7.967H7.5a.75.75 0 0 1-.565-1.263l8.25-11.25a.75.75 0 0 1 .923-.288Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tiêu thụ</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $car->consumed }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="my-6">
                    <p class="text-xl font-semibold text-gray-800">Mô tả</p>
                    <p class="mt-3 text-base text-gray-700 leading-relaxed">{!!nl2br($car->desc)!!}</p>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="my-6">
                    <h2 class="text-xl font-semibold text-gray-800">Điều khoản</h2>
                    <div class="mt-3 text-base text-gray-700 leading-relaxed">
                        <p>Quy định khác:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Sử dụng xe đúng mục đích.</li>
                            <li>Không sử dụng xe thuê vào mục đích phi pháp, trái pháp luật.</li>
                            <li>Không sử dụng xe thuê để cầm cố, thế chấp.</li>
                            <li>Không hút thuốc, nhả kẹo cao su, xả rác trong xe.</li>
                            <li>Không chở hàng quốc cấm dễ cháy nổ.</li>
                            <li>Không chở hoa quả, thực phẩm nặng mùi trong xe.</li>
                            <li>Khi trả xe, nếu xe bẩn hoặc có mùi trong xe, khách hàng vui lòng vệ sinh xe sạch sẽ hoặc gửi phụ thu phí vệ sinh xe.</li>
                        </ul>
                        <p class="mt-2">Trân trọng cảm ơn, chúc quý khách hàng có những chuyến đi tuyệt vời !</p>
                    </div>
                </div>

                <hr class="my-6 border-gray-200">

                <div class="my-6">
                    <h2 class="text-xl font-semibold text-gray-800">Chính sách hủy chuyến</h2>
                    <div class="mt-4 border border-gray-200 rounded-lg overflow-hidden">
                        <div class="grid grid-cols-2 font-semibold text-base text-gray-800">
                            <div class="p-4 border-b border-r border-gray-200">Thời Điểm Hủy Chuyến</div>
                            <div class="p-4 border-b border-gray-200">Phí Hủy Chuyến</div>
                        </div>
                        <div class="grid grid-cols-2 text-base items-center">
                            <div class="p-4 border-r border-gray-200">Trong Vòng 1h Sau Giờ Chốt</div>
                            <div class="p-4 flex items-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full mr-3 bg-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                Miễn phí
                            </div>
                        </div>
                        <div class="grid grid-cols-2 text-base items-center">
                            <div class="p-4 border-t border-r border-gray-200">
                                Trước Chuyến Đi > 7 Ngày
                                <div class="text-sm text-gray-500 mt-1">(Sau 1h Giờ Chốt)</div>
                            </div>
                            <div class="p-4 border-t border-gray-200 flex items-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full mr-3 bg-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                10% giá trị chuyến đi
                            </div>
                        </div>
                        <div class="grid grid-cols-2 text-base items-center">
                            <div class="p-4 border-t border-r border-gray-200">
                                Trong Vòng 7 Ngày Trước Chuyến Đi
                                <div class="text-sm text-gray-500 mt-1">(Sau 1h Giờ Chốt)</div>
                            </div>
                            <div class="p-4 border-t border-gray-200 flex items-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full mr-3 bg-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                40% giá trị chuyến đi
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-sm text-gray-600 leading-loose">
                        <ul class="list-none p-0 m-0 space-y-2.5">
                            <li class="relative pl-5 before:content-['*'] before:absolute before:left-0 before:top-0">Chính sách hủy chuyến áp dụng chung cho cả khách thuê và chủ xe (ngoài ra, tùy vào thời điểm hủy chuyến, chủ xe có thể bị đánh giá từ 2-3* trên hệ thống).</li>
                            <li class="relative pl-5 before:content-['*'] before:absolute before:left-0 before:top-0">Khách thuê không nhận xe sẽ mất phí hủy chuyến (40% giá trị chuyến đi).</li>
                            <li class="relative pl-5 before:content-['*'] before:absolute before:left-0 before:top-0">Chủ xe không giao xe sẽ hoàn tiền giữ chỗ & bồi thường phí hủy chuyến cho khách thuê (40% giá trị chuyến đi).</li>
                            <li class="relative pl-5 before:content-['*'] before:absolute before:left-0 before:top-0">Tiền giữ chỗ & bồi thường do chủ xe hủy chuyến (nếu có) sẽ được Mioto hoàn trả đến khách thuê bằng chuyển khoản ngân hàng trong vòng 1-3 ngày làm việc kế tiếp. Xem thêm <a href="#" class="text-blue-600 font-medium hover:underline">Thủ tục hoàn tiền & bồi thường hủy chuyến</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-span-1">
                <div class="sticky top-4">
                    <div class="w-[95%] mx-auto bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gray-600">Giá mỗi ngày</span>
                            <span class="text-xl font-bold text-green-600">{{ number_format((int)$car->price, 0, ',', '.') }}K</span>
                        </div>
                        @php($userId = \Illuminate\Support\Facades\Auth::id())
                        @php($today = \Carbon\Carbon::today()->toDateString())
                        @php($isBooked = \App\Models\Booking::activeOn($today)->where('car_id', $car->id)->exists())
                        @if(!$userId)
                            <div class="text-sm text-gray-700 mb-3">Vui lòng đăng nhập để thuê xe</div>
                            <a href="/login" class="w-full bg-green-500 text-white text-lg font-semibold p-3 rounded-lg cursor-pointer hover:bg-green-600 transition-colors">Đăng nhập</a>
                        @elseif($car->owner_id == $userId)
                            <div class="text-sm text-gray-700">Bạn là chủ xe này. Không thể thuê xe của chính mình.</div>
                        @elseif($isBooked)
                            <div class="text-sm text-red-600 font-medium mb-3">Xe đang được thuê</div>
                            <button class="w-full bg-gray-300 text-gray-600 text-lg font-semibold p-3 rounded-lg cursor-not-allowed" disabled>Không thể thuê</button>
                        @else
                            <form method="POST" action="{{ url('/book/' . $car->id) }}" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Ngày kết thúc</label>
                                    <input type="date" name="end_date" class="w-full border border-gray-300 rounded-lg px-3 py-2" required min="{{ \Carbon\Carbon::today()->toDateString() }}">
                                </div>
                                <button type="submit" class="w-full bg-orange-500 text-white text-lg font-semibold p-3 rounded-lg cursor-pointer hover:bg-orange-600 transition-colors">
                                    Thuê xe ngay
                                </button>
                            </form>
                        @endif
                        @if(session('error'))
                            <div class="mt-3 text-sm text-red-600">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="mt-3 text-sm text-green-600">{{ session('success') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
