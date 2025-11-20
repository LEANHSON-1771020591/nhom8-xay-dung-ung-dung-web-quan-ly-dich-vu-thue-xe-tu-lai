<nav class="bg-white py-4 relative z-[1000]">
    <div class="max-w-[1200px] mx-auto px-5 md:px-6 flex justify-between items-center">
        <a class="h-full flex justify-center items-center" href="{{ url('/') }}">
            <img class="w-[100px] object-contain h-full" src="{{ asset('images/logos/logo.png') }}" alt="">
        </a>

        <ul id="mobileNav"
            class="hidden md:flex items-center md:space-x-6 absolute md:static left-0 top-full w-full md:w-auto
                   bg-white md:bg-transparent flex-col md:flex-row py-2 md:py-0 shadow-md md:shadow-none">
            <li class="md:ml-6 my-2 md:my-0 text-center w-full md:w-auto">
                <a href="{{ url('/') }}"
                    class="no-underline text-gray-800 font-medium px-3 py-2 transition-colors duration-300 hover:text-green-600 whitespace-nowrap">
                    Trang chủ
                </a>
            </li>
            <li class="md:ml-6 my-2 md:my-0 text-center w-full md:w-auto">
                <a href="{{ url('/about') }}"
                    class="no-underline text-gray-800 font-medium px-3 py-2 transition-colors duration-300 hover:text-green-600 whitespace-nowrap">
                    Về Vato
                </a>
            </li>
            <li class="md:ml-6 my-2 md:my-0 text-center w-full md:w-auto">
                <a href="{{ url('/owner') }}"
                    class="no-underline text-gray-800 font-medium px-3 py-2 transition-colors duration-300 hover:text-green-600 whitespace-nowrap">
                    Trở thành chủ xe
                </a>
            </li>
            <li class="md:ml-6 my-2 md:my-0 text-center w-full md:w-auto">
                <a href="{{ url('/my-trips') }}"
                    class="no-underline text-gray-800 font-medium px-3 py-2 transition-colors duration-300 hover:text-green-600 whitespace-nowrap">
                    Xe của tôi
                </a>
            </li>
            @guest
            <li class="md:ml-6 my-2 md:my-0 text-center w-full md:w-auto">
                <a href="{{ url('/register') }}"
                    class="inline-block border border-gray-300 rounded-md px-5 py-2 cursor-pointer transition-all duration-300
                          text-gray-600 hover:text-green-600 hover:border-green-600 bg-white">
                    Đăng ký
                </a>
            </li>
            <li class="md:ml-6 my-2 md:my-0 text-center w-full md:w-auto">
                <a href="{{ url('/login') }}"
                    class="inline-block border border-gray-900 rounded-md px-5 py-2 cursor-pointer transition-all duration-300
                          bg-gray-900 text-white hover:bg-white hover:text-green-600 hover:border-green-600">
                    Đăng nhập
                </a>
            </li>
            @endguest
            @auth
            <li class="md:ml-6 my-2 md:my-0 text-center w-full md:w-auto">
                <span class="inline-block border border-green-600 rounded-md px-5 py-2 text-green-700 bg-green-50 font-medium">
                    {{ auth()->user()->name }}
                </span>
            </li>
            <li class="md:ml-6 my-2 md:my-0 text-center w-full md:w-auto">
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="inline-block border border-gray-300 rounded-md px-5 py-2 cursor-pointer transition-all duration-300 text-gray-600 hover:text-green-600 hover:border-green-600 bg-white">Đăng xuất</button>
                </form>
            </li>
            @endauth
        </ul>

        <button id="menuBtn" type="button" aria-expanded="false" aria-controls="mobileNav" aria-label="Toggle navigation"
            class="md:hidden flex flex-col justify-center cursor-pointer">
            <span class="h-[3px] w-[25px] bg-gray-600 mb-[5px] rounded-[2px] transition-all duration-300"></span>
            <span class="h-[3px] w-[25px] bg-gray-600 mb-[5px] rounded-[2px] transition-all duration-300"></span>
            <span class="h-[3px] w-[25px] bg-gray-600 rounded-[2px] transition-all duration-300"></span>
        </button>
    </div>
</nav>
