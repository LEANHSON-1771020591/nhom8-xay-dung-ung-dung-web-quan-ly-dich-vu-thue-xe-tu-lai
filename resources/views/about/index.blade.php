<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vato - Về chúng tôi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-nav></x-nav>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div>
                <h1 class="text-3xl lg:text-5xl font-bold text-gray-900 leading-tight">Vato - Cùng bạn đến mọi hành trình</h1>
                <p class="mt-6 text-gray-700 leading-relaxed">Mỗi chuyến đi là một hành trình khám phá cuộc sống và thế giới xung quanh, là cơ hội học hỏi và chinh phục những điều mới lạ của mỗi cá nhân để trở nên tốt hơn. Do đó, chất lượng trải nghiệm của khách hàng là ưu tiên hàng đầu và là nguồn cảm hứng của đội ngũ Vato.</p>
                <p class="mt-4 text-gray-700 leading-relaxed">Vato là nền tảng chia sẻ ô tô, sứ mệnh của chúng tôi không chỉ dừng lại ở việc kết nối chủ xe và khách hàng một cách nhanh chóng - an toàn - tiện lợi, mà còn hướng đến việc truyền cảm hứng khám phá đến cộng đồng qua những chuyến đi trên nền tảng của chúng tôi.</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <img class="w-full h-64 object-cover rounded-2xl" src="https://images.pexels.com/photos/757183/pexels-photo-757183.jpeg" alt="Hành trình">
                <img class="w-full h-64 object-cover rounded-2xl" src="https://images.pexels.com/photos/210182/pexels-photo-210182.jpeg" alt="Lái xe">
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Drive. Explore. Inspire.</h2>
                <p class="mt-2 text-gray-700">Cầm lái và Khám phá thế giới đầy Cảm hứng.</p>
                <p class="mt-6 text-gray-700 leading-relaxed">Vato đặt mục tiêu trở thành cộng đồng người dùng ô tô văn minh & uy tín tại Việt Nam, nhằm mang lại những giá trị thiết thực cho tất cả những thành viên hướng đến một cuộc sống tốt đẹp hơn.</p>
                <p class="mt-4 text-gray-700 leading-relaxed">Chúng tôi tin rằng mỗi hành trình đều quan trọng, vì vậy đội ngũ và các đối tác của Vato với nhiều kinh nghiệm về lĩnh vực cho thuê xe, công nghệ, bảo hiểm & du lịch sẽ mang đến cho hành trình của bạn thêm nhiều trải nghiệm mới mẻ, an toàn và thú vị ở mức cao nhất.</p>
            </div>
            <div>
                <img class="w-full h-72 object-cover rounded-2xl" src="https://images.pexels.com/photos/1118448/pexels-photo-1118448.jpeg" alt="Khám phá">
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-900 mb-12">Vato và những con số</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 text-center">
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 2h6a1 1 0 011 1v3h2a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2V3a1 1 0 011-1zm1 4h4V3h-4v3z" />
                </svg>
                <p class="mt-3 text-2xl font-bold">200.000+</p>
                <p class="text-gray-600">Chuyến đi đầy cảm hứng Vato đã đồng hành</p>
            </div>
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 8v-2a5 5 0 015-5h4a5 5 0 015 5v2H5z" />
                </svg>
                <p class="mt-3 text-2xl font-bold">100.000+</p>
                <p class="text-gray-600">Khách hàng đã trải nghiệm dịch vụ</p>
            </div>
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a10 10 0 110 20 10 10 0 010-20zm0 6a6 6 0 016 6H6a6 6 0 016-6z" />
                </svg>
                <p class="mt-3 text-2xl font-bold">10.000+</p>
                <p class="text-gray-600">Đối tác chủ xe trong cộng đồng Vato</p>
            </div>
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 14l2-4a2 2 0 011.8-1.1h9.4a2 2 0 011.6.9l3 4v4h-2a2 2 0 11-4 0H9a2 2 0 11-4 0H3v-4z" />
                </svg>
                <p class="mt-3 text-2xl font-bold">100+</p>
                <p class="text-gray-600">Dòng xe khác nhau đang cho thuê</p>
            </div>
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.7 2 6 4.7 6 8c0 5 6 12 6 12s6-7 6-12c0-3.3-2.7-6-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                </svg>
                <p class="mt-3 text-2xl font-bold">20+</p>
                <p class="text-gray-600">Thành phố Vato đã có mặt</p>
            </div>
            <div class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                <p class="mt-3 text-2xl font-bold">4.95/5★</p>
                <p class="text-gray-600">Điểm đánh giá trung bình từ >100.000 khách hàng</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl lg:text-4xl font-bold text-center text-gray-900 mb-10">Bắt đầu ngay hôm nay</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="relative overflow-hidden rounded-2xl w-[685px] h-[510px]">
                <img class="absolute inset-0 w-full h-full object-cover" src="https://www.mioto.vn/static/media/gia_thue_xe_tu_lai_4cho_tai_hanoi.e6ebc385.png" alt="Thuê xe tự lái">
                <div class="absolute inset-0" style="background: linear-gradient(90deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.35) 45%, rgba(0,0,0,0.0) 80%); clip-path: polygon(0 0, 85% 0, 65% 100%, 0% 100%);"></div>
                <div class="absolute inset-0 z-10 flex flex-col justify-end p-6 sm:p-8 text-white drop-shadow">
                    <p class="text-2xl font-semibold">Xe đã sẵn sàng.<br />Bắt đầu hành trình ngay!</p>
                    <p class="mt-2 max-w-md">Tự tay cầm lái chiếc xe bạn yêu thích cho hành trình thêm hứng khởi.</p>
                    <a href="{{ url('/') }}" class="inline-flex items-center justify-center w-fit mt-4 bg-green-500 hover:bg-green-600 text-white font-medium px-5 py-2 text-sm rounded-md shadow-md">Thuê xe tự lái</a>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl w-[685px] h-[510px]">
                <img class="absolute inset-0 w-full h-full object-cover" src="https://www.mioto.vn/static/media/thue_xe_oto_tu_lai_va_co_tai.9df79c9f.png" alt="Thuê xe có tài xế">
                <div class="absolute inset-0" style="background: linear-gradient(270deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.35) 45%, rgba(0,0,0,0.0) 80%); clip-path: polygon(100% 0, 100% 100%, 20% 100%, 35% 0);"></div>
                <div class="absolute inset-0 z-10 flex flex-col justify-end items-end p-6 sm:p-8 text-white drop-shadow text-right">
                    <p class="text-2xl font-semibold">Tài xế của bạn đã đến!</p>
                    <p class="mt-2 ml-auto max-w-md">Chuyến đi thêm thú vị cùng các bác tài xế trên Vato.</p>
                    <a href="/filter/ho-chi-minh" class="inline-block mt-4 bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 text-base rounded-lg shadow-md">Thuê xe có tài xế</a>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
