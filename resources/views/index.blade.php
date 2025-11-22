<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vato - Cùng Bạn Trên Mọi Hành Trình</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-nav></x-nav>

    <div class="relative max-w-[1250px] mx-auto my-10 h-[580px] flex items-center justify-center">
        <img src="{{ asset('images/banner/banner.jpg') }}" alt=""
            class="w-full h-full object-cover rounded-[16px]">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <p class="text-white text-[48px] font-semibold max-w-[800px]">Vato - Cùng Bạn Trên Mọi Hành Trình</p>
            <div class="w-[300px] h-[2px] bg-white my-4"></div>
            <p class="text-white text-[22px] font-semibold w-4/5 lg:w-[650px] overflow-hidden whitespace-nowrap animate-[typing-text_4s_steps(77,_end)_forwards,done-text_0s_5s_forwards]">
                Trải nghiệm sự khác biệt từ
                <span class="text-green-600 font-semibold">hơn 10.000</span>
                xe gia đình đời mới khắp Việt Nam
            </p>
        </div>
    </div>

    <section class="py-[60px] my-10">
        <div class="w-[1200px] mx-auto p-4 bg-white rounded-xl shadow-lg flex items-center justify-between space-x-4">
            <div class="flex items-center space-x-3 w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>

                <div class="flex flex-col w-full">
                    <label class="text-sm text-gray-500 font-light mb-1">Địa điểm áp dụng hiện tại</label>

                    <div class="relative w-full group">
                        <button id="city-select-button"
                            class="text-left block w-full bg-white text-lg font-semibold text-gray-800 border-none p-0 focus:outline-none focus:ring-0 cursor-pointer flex justify-between items-center"
                            aria-expanded="false"
                            aria-haspopup="listbox">
                            <span id="selected-city-text">TP. Hồ Chí Minh</span>
                            <svg class="fill-current h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </button>

                        <ul id="city-options-list"
                            class="hidden absolute z-10 w-full mt-3 bg-white border border-gray-200 rounded-md shadow-lg overflow-hidden max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="listbox"
                            aria-labelledby="city-select-button">

                            <li data-value="ho-chi-minh" role="option" aria-selected="true" class="text-lg text-gray-800 font-medium cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-green-100 hover:text-green-700 transition duration-150">
                                TP. Hồ Chí Minh
                            </li>
                            <li data-value="ha-noi" role="option" aria-selected="false" class="text-lg text-gray-800 font-medium cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-green-100 hover:text-green-700 transition duration-150">
                                Hà Nội
                            </li>
                            <li data-value="da-nang" role="option" aria-selected="false" class="text-lg text-gray-800 font-medium cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-green-100 hover:text-green-700 transition duration-150">
                                Đà Nẵng
                            </li>
                            <li data-value="hai-phong" role="option" aria-selected="false" class="text-lg text-gray-800 font-medium cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-green-100 hover:text-green-700 transition duration-150">
                                Hải Phòng
                            </li>
                            <li data-value="thanh-hoa" role="option" aria-selected="false" class="text-lg text-gray-800 font-medium cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-green-100 hover:text-green-700 transition duration-150">
                                Thanh Hóa
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <button id="search-button" class="flex-shrink-0 bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-6 rounded-lg shadow-md transition duration-150 ease-in-out">
                Tìm Xe
            </button>
        </div>
    </section>

    <section class=" py-[60px] my-10">
        <div class="max-w-[1200px] mx-auto px-5 text-center">
            <p class="text-[48px] font-medium text-gray-800 mb-2">Chương Trình Khuyến Mãi</p>
            <p class="text-[24px] text-gray-700">
                Nhận nhiều ưu đãi hấp dẫn từ <span class="text-green-600 font-bold">Vato</span>
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-[60px]">
                <div class="bg-white rounded-[16px] overflow-hidden">
                    <img src="https://n1-cstg.mioto.vn/g/2025/09/17/16/4NMYQ32T.jpg" alt="Halloween Khuyến Mãi"
                        class="w-full h-[250px] object-cover rounded-[16px] transition hover:brightness-75 cursor-pointer">
                </div>

                <div class="bg-white rounded-[16px] overflow-hidden">
                    <img src="https://n1-cstg.mioto.vn/g/2025/09/01/09/3I8R333Q.jpg" alt="Đặt xe dễ dàng"
                        class="w-full h-[250px] object-cover rounded-[16px] transition hover:brightness-75 cursor-pointer">
                </div>

                <div class="bg-white rounded-[16px] overflow-hidden">
                    <img src="https://n1-cstg.mioto.vn/g/2025/09/10/09/FYSFNSQ2.jpg" alt="Linh hoạt theo giờ"
                        class="w-full h-[250px] object-cover rounded-[16px] transition hover:brightness-75 cursor-pointer">
                </div>
            </div>
        </div>
    </section>


    <section class="bg-[#f8f9fa] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-900 mb-12">Xe Dành Cho Bạn</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($cars as $car)
                <div class="bg-white rounded-xl border border-gray-200 p-3 group transform hover:-translate-y-2 transition-transform duration-300">
                    <a href="{{ url('/car/' . $car->slug) }}">
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
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-900 mb-12">Địa Điểm Nổi Bật</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ url('/filter/ho-chi-minh') }}" class="group block">
                    <div class="relative h-[450px] rounded-2xl overflow-hidden">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" src="https://n1-cstg.mioto.vn/g/2025/02/05/15/5MB4MWA8.jpg" alt="TP. Hồ Chí Minh">
                        <div class="absolute bottom-0 left-0 p-5 text-white">
                            <h3 class="font-bold text-xl [text-shadow:1px_1px_2px_rgba(0,0,0,0.8)]">Ho Chi Minh</h3>
                        </div>
                    </div>
                </a>
                <a href="{{ url('/filter/ha-noi') }}" class="group block">
                    <div class="relative h-[450px] rounded-2xl overflow-hidden">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" src="https://n1-cstg.mioto.vn/g/2025/02/05/17/EZ3I68NZ.jpg" alt="Hà Nội">
                        <div class="absolute bottom-0 left-0 p-5 text-white">
                            <h3 class="font-bold text-xl [text-shadow:1px_1px_2px_rgba(0,0,0,0.8)]">Ha Noi</h3>
                        </div>
                    </div>
                </a>
                <a href="{{ url('/filter/da-nang') }}" class="group block">
                    <div class="relative h-[450px] rounded-2xl overflow-hidden">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" src="https://n1-cstg.mioto.vn/g/2025/02/05/15/5VEX6XMN.jpg" alt="Đà Nẵng">
                        <div class="absolute bottom-0 left-0 p-5 text-white">
                            <h3 class="font-bold text-xl [text-shadow:1px_1px_2px_rgba(0,0,0,0.8)]">Da Nang</h3>
                        </div>
                    </div>
                </a>

                <a href="{{ url('/filter/thanh-hoa') }}" class="group block">
                    <div class="relative h-[450px] rounded-2xl overflow-hidden">
                        <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" src="https://n1-cstg.mioto.vn/g/2025/02/05/15/595BB2FL.jpg" alt="Thanh Hóa">
                        <div class="absolute bottom-0 left-0 p-5 text-white">
                            <h3 class="font-bold text-xl [text-shadow:1px_1px_2px_rgba(0,0,0,0.8)]">Thanh Hoa</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="py-10 sm:py-14">
        <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-900 mb-12">Ưu Điểm Của Mioto</h2>
        <p class="text-center text-[16px] font-normal text-gray-500 mb-12">
            Những tính năng giúp bạn dễ dàng hơn khi thuê xe trên Mioto.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="rounded-[16px] h-[450px] text-center w-full max-w-[350px] p-6 sm:p-8">
                <img class="mx-auto mb-4 w-[200px] h-[200px] object-contain" src="https://www.mioto.vn/static/media/thue_xe_co_tai_xe.a6f7dc54.svg" alt="Lái xe an toàn">
                <div class="text-[24px] font-semibold mb-3">Lái xe an toàn cùng Vato</div>
                <div class="text-[16px] font-normal text-gray-500">
                    Chuyến đi trên Vato được bảo vệ với Gói bảo hiểm thuê xe tự lái từ MIC & DBV (VNI).
                    Khách thuê sẽ chỉ bồi thường tối đa 2.000.000VNĐ trong trường hợp có sự cố ngoài ý muốn.
                </div>
            </div>

            <div class="rounded-[16px] h-[450px] text-center w-full max-w-[350px] p-6 sm:p-8">
                <img src="https://www.mioto.vn/static/media/dich_vu_thue_xe_tu_lai_hanoi.f177339e.svg" alt="An tâm đặt xe"
                    class="mx-auto mb-4 w-[200px] h-[200px] object-contain">
                <div class="text-[24px] font-semibold mb-3">An tâm đặt xe</div>
                <div class="text-[16px] font-normal text-gray-500">
                    Chuyến đi trên Vato được bảo vệ với Gói bảo hiểm thuê xe tự lái từ MIC & DBV (VNI).
                    Khách thuê sẽ chỉ bồi thường tối đa 2.000.000VNĐ trong trường hợp có sự cố ngoài ý muốn.
                </div>
            </div>

            <div class="rounded-[16px] h-[450px] text-center w-full max-w-[350px] p-6 sm:p-8">
                <img src="https://www.mioto.vn/static/media/cho_thue_xe_tu_lai_tphcm.1e7cb1c7.svg" alt="Thủ tục đơn giản"
                    class="mx-auto mb-4 w-[200px] h-[200px] object-contain">
                <div class="text-[24px] font-semibold mb-3">Thủ tục đơn giản</div>
                <div class="text-[16px] font-normal text-gray-500">
                    Không tính phí huỷ chuyến trong vòng 1h sau khi thanh toán giữ chỗ.
                    Hoàn tiền giữ chỗ và bồi thường 100% nếu chủ xe huỷ chuyến trong vòng 7 ngày trước chuyến đi.
                </div>
            </div>

            <div class="rounded-[16px] h-[450px] text-center w-full max-w-[350px]">
                <img src="https://www.mioto.vn/static/media/cho_thue_xe_tu_lai_hanoi.735438af.svg" alt="Thanh toán dễ dàng"
                    class="mx-auto mb-4 w-[200px] h-[200px] object-contain">
                <div class="text-[24px] font-semibold mb-2">Thanh toán dễ dàng</div>
                <div class="text-[16px] font-normal text-gray-500">
                    Chỉ cần có CCCD gắn chip (Hoặc Passport) & Giấy phép lái xe là bạn đã đủ điều kiện thuê xe trên Vato.
                </div>
            </div>

            <div class="rounded-[16px] h-[450px] text-center w-full max-w-[350px]">
                <img src="https://www.mioto.vn/static/media/thue_xe_tu_lai_gia_re_hcm.ffd1319e.svg" alt="Giao xe tận nơi"
                    class="mx-auto mb-4 w-[200px] h-[200px] object-contain">
                <div class="text-[24px] font-semibold mb-2">Giao xe tận nơi</div>
                <div class="text-[16px] font-normal text-gray-500">
                    Bạn có thể lựa chọn giao xe tận nhà/sân bay... Phí tiết kiệm chỉ từ 15k/km.
                </div>
            </div>

            <div class="rounded-[16px] h-[450px] text-center w-full max-w-[350px]">
                <img src="https://www.mioto.vn/static/media/thue_xe_tu_lai_gia_re_hanoi.4035317e.svg" alt="Dòng xe đa dạng"
                    class="mx-auto mb-4 w-[200px] h-[200px] object-contain">
                <div class="text-[24px] font-semibold mb-2">Dòng xe đa dạng</div>
                <div class="text-[16px] font-normal text-gray-500">
                    Hơn 100 dòng xe cho bạn tuỳ ý lựa chọn: Mini, Sedan, CUV, SUV, MPV, Bán tải.
                </div>
            </div>
        </div>
    </section>


    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-900 mb-10">Dịch Vụ Của Vato</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="relative overflow-hidden rounded-2xl w-[685px] h-[510px]">
                <img class="absolute inset-0 w-full h-full object-cover" src="https://www.mioto.vn/static/media/gia_thue_xe_tu_lai_4cho_tai_hanoi.e6ebc385.png" alt="Thuê xe tự lái">
                <div class="absolute inset-0" style="background: linear-gradient(90deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.35) 45%, rgba(0,0,0,0.0) 80%); clip-path: polygon(0 0, 85% 0, 65% 100%, 0% 100%);"></div>
                <div class="absolute inset-0 z-10 flex flex-col justify-end p-6 sm:p-8 text-white drop-shadow">
                    <p class="text-2xl font-semibold">Xe đã sẵn sàng.<br />Bắt đầu hành trình ngay!</p>
                    <p class="mt-2 max-w-md">Tự tay cầm lái chiếc xe bạn yêu thích cho hành trình thêm hứng khởi.</p>
                    <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-fit mt-4 bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 text-sm rounded-md shadow-md">Thuê xe ngay</a>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl w-[685px] h-[510px]">
                <img class="absolute inset-0 w-full h-full object-cover" src="https://www.mioto.vn/static/media/thue_xe_oto_tu_lai_va_co_tai.9df79c9f.png" alt="Thuê xe có tài xế">
                <div class="absolute inset-0" style="background: linear-gradient(270deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.35) 45%, rgba(0,0,0,0.0) 80%); clip-path: polygon(100% 0, 100% 100%, 20% 100%, 35% 0);"></div>
                <div class="absolute inset-0 z-10 flex flex-col justify-end items-end p-6 sm:p-8 text-white drop-shadow text-right">
                    <p class="text-2xl font-semibold">Tài xế của bạn đã đến!</p>
                    <p class="mt-2 ml-auto max-w-md">Chuyến đi thêm thú vị cùng các bác tài xế trên Vato.</p>
                    <a href="{{ url('/filter/ho-chi-minh') }}" class="inline-flex items-center justify-center w-fit mt-4 bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 text-sm rounded-md shadow-md">Thuê xe ngay</a>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-[1200px] mx-auto px-5 my-10">
        <div class="text-[36px] font-semibold text-gray-800 text-center mt-[60px] mb-[10px]">
            Hướng Dẫn Thuê Xe
        </div>
        <div class="text-[16px] text-gray-600 text-center mb-[50px]">
            Chỉ với 4 bước đơn giản để trải nghiệm thuê xe Mioto một cách nhanh chóng
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[40px] w-full mx-auto my-10">
            <div class="text-center p-5">
                <img src="https://www.mioto.vn/static/media/cho_thue_xe_co_taigia_re_tphcm.12455eba.svg"
                    alt="Lái xe an toàn" class="w-[240px] h-[240px] object-contain mx-auto mb-[20px]">
                <div class="text-[24px] text-gray-800 leading-relaxed font-bold">
                    <span class="inline text-[24px] font-semibold text-green-600 mr-[10px]">01</span>
                    Đặt xe trên app/web Vito
                </div>
            </div>

            <div class="text-center p-5">
                <img src="https://www.mioto.vn/static/media/gia_thue_xe_7cho_tai_tphcm.9455973a.svg"
                    alt="Lái xe an toàn" class="w-[240px] h-[240px] object-contain mx-auto mb-[20px]">
                <div class="text-[24px] text-gray-800 leading-relaxed font-bold">
                    <span class="inline text-[24px] font-semibold text-green-600 mr-[10px]">02</span>
                    Nhận xe
                </div>
            </div>

            <div class="text-center p-5">
                <img src="https://www.mioto.vn/static/media/gia_thue_xe_7cho_tai_hanoi.0834bed8.svg"
                    alt="Lái xe an toàn" class="w-[240px] h-[240px] object-contain mx-auto mb-[20px]">
                <div class="text-[24px] text-gray-800 leading-relaxed font-bold">
                    <span class="inline text-[24px] font-semibold text-green-600 mr-[10px]">03</span>
                    Bắt đầu hành trình
                </div>
            </div>

            <div class="text-center p-5">
                <img src="https://www.mioto.vn/static/media/gia_thue_xe_4cho_tai_tphcm.9dcd3930.svg"
                    alt="Lái xe an toàn" class="w-[240px] h-[240px] object-contain mx-auto mb-[20px]">
                <div class="text-[24px] text-gray-800 leading-relaxed font-bold">
                    <span class="inline text-[24px] font-semibold text-green-600 mr-[10px]">04</span>
                    Trả xe & kết thúc chuyến đi
                </div>
            </div>
        </div>
    </section>


    <section class="bg-gradient-to-tr from-[#f4ebc8] to-[#f6e9c4] w-[70%] h-[600px] mx-auto rounded-[24px] py-[40px] sm:py-[60px]">
        <div class="max-w-[1200px] mx-auto px-5 grid grid-cols-1 lg:grid-cols-2 gap-[60px] items-center">
            <div class="text-center">
                <img
                    src="https://www.mioto.vn/static/media/thue_xe_co_tai_xe_tphcm_gia_re.84f8483d.png"
                    alt="Vato App"
                    class="max-w-full h-auto rounded-[20px] mx-auto">
            </div>
            <div class="py-5 flex flex-col justify-center">
                <div class="mb-5">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
                        <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z" fill="#4CAF50" />
                    </svg>
                </div>
                <h2 class="text-center text-gray-800 font-bold leading-tight mb-5 text-[24px] sm:text-[28px] lg:text-[48px]">
                    Bạn muốn biết thêm về Vato?
                </h2>
                <p class="mx-auto text-center text-gray-800 leading-relaxed mt-[30px] w-full max-w-[500px] text-[14px] lg:text-[20px]">
                    Vato kết nối khách hàng có nhu cầu thuê xe với hàng ngàn chủ xe ô tô ở TP.HCM, Hà Nội & các tỉnh
                    thành khác. Vato hướng đến việc xây dựng cộng đồng người dùng ô tô văn minh & uy tín tại Việt Nam.
                </p>
                <a href="{{ url('/about') }}"
                    class="mx-auto mt-6 bg-green-500 text-white border-0 px-[30px] py-[15px] text-[16px] font-semibold rounded-[8px] cursor-pointer transition-all duration-300 transform hover:bg-green-600 hover:-translate-y-[2px] hover:shadow-lg">
                    Về Vato
                </a>
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-tr from-[#f8f4ff] to-[#e8f0ff] w-[70%] mx-auto rounded-[24px] py-20 my-[60px]">
        <div class="max-w-[1200px] mx-auto px-5 grid grid-cols-1 lg:grid-cols-2 gap-[60px] items-center">
            <div class="py-5 flex flex-col items-center justify-center">
                <div class="mb-5">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">
                        <path
                            d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5H6.5C5.84 5 5.28 5.42 5.08 6.01L3 12V20C3 20.55 3.45 21 4 21H5C5.55 21 6 20.55 6 20V19H18V20C18 20.55 18.45 21 19 21H20C20.55 21 21 20.55 21 20V12L18.92 6.01ZM6.5 16C5.67 16 5 15.33 5 14.5S5.67 13 6.5 13 8 13.67 8 14.5 7.33 16 6.5 16ZM17.5 16C16.67 16 16 15.33 16 14.5S16.67 13 17.5 13 19 13.67 19 14.5 18.33 16 17.5 16ZM5 11L6.5 6.5H17.5L19 11H5Z"
                            fill="#4A90E2" />
                    </svg>
                </div>
                <h2 class="text-center text-gray-800 leading-tight mb-5 font-semibold text-[24px] sm:text-[28px] lg:text-[48px] max-w-[400px]">
                    Bạn muốn cho thuê xe?
                </h2>
                <p class="text-center text-gray-800 leading-relaxed mb-[30px] text-[14px] lg:text-[16px] max-w-[400px]">
                    Hơn 10.000 chủ xe đang cho thuê hiệu quả trên Vato<br>
                    Đăng ký trở thành đối tác của chúng tôi ngay hôm nay để gia tăng thu nhập hàng tháng.
                </p>
                <div class="flex gap-[15px] flex-wrap justify-center">
                    <a href="{{ url('/owner') }}"
                        class="inline-block min-w-[150px] px-[30px] py-[15px] text-[16px] font-semibold rounded-[6px] bg-blue-500 text-white border-2 border-blue-500 transition-all duration-300 hover:bg-[#357ABD] hover:border-[#357ABD] hover:-translate-y-[2px] hover:shadow-lg">
                        Trở thành chủ xe
                    </a>
                </div>
            </div>
            <div class="text-center">
                <img
                    src="https://www.mioto.vn/static/media/thue_xe_oto_tu_lai_di_du_lich_gia_re.fde3ac82.png"
                    alt="Car Rental"
                    class="max-w-full h-auto mx-auto">
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-900 mb-12">VATO Blog</h2>
        @php($main = ($blogs ?? collect())->first())
        @php($others = ($blogs ?? collect())->slice(1, 2))
        @if(($blogs ?? collect())->isEmpty())
        <div class="text-center text-gray-600">Chưa có bài viết trong hệ thống</div>
        @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            <div class="flex flex-col gap-6">
            @foreach($others as $b)
            <a href="{{ url('/blog/'.$b->id) }}" class="relative overflow-hidden rounded-2xl h-[240px] group">
                @php($srcB = \Illuminate\Support\Str::startsWith($b->thumbnail, ['http://','https://','//']) ? $b->thumbnail : asset('storage/'.$b->thumbnail))
                <img loading="lazy" decoding="async" referrerpolicy="no-referrer" class="absolute inset-0 w-full h-full object-cover" src="{{ $srcB }}" alt="{{ $b->title }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="relative z-10 p-4 text-white">
                        <p class="text-xs opacity-80">{{ optional($b->created_at)->format('d/m/Y') }}</p>
                        <h4 class="mt-1 text-base sm:text-lg font-semibold leading-snug">{{ $b->title }}</h4>
                    </div>
                </a>
                @endforeach
            </div>
            <a href="{{ url('/blog/'.$main->id) }}" class="lg:col-span-2 relative overflow-hidden rounded-2xl group">
            @php($srcM = \Illuminate\Support\Str::startsWith($main->thumbnail, ['http://','https://','//']) ? $main->thumbnail : asset('storage/'.$main->thumbnail))
            <img loading="lazy" decoding="async" referrerpolicy="no-referrer" class="absolute inset-0 w-full h-full object-cover" src="{{ $srcM }}" alt="{{ $main->title }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                <div class="relative z-10 p-6 sm:p-8 text-white">
                    <p class="text-xs sm:text-sm opacity-80 mb-2">{{ optional($main->created_at)->format('d/m/Y') }}</p>
                    <h3 class="text-xl sm:text-2xl lg:text-3xl font-semibold leading-tight">{{ $main->title }}</h3>
                </div>
            </a>
        </div>
        @endif
    </section>