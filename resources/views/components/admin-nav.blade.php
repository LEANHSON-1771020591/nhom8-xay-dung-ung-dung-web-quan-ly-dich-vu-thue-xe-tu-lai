<aside class="fixed left-0 top-0 h-screen w-64 bg-gray-900 text-white flex flex-col">
    <div class="px-4 py-4 border-b border-gray-800 flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 text-green-400" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z"/></svg>
        <a href="/admin" class="text-lg font-bold">Vato Admin</a>
    </div>
    <nav class="flex-1 px-2 py-3 space-y-1">
        <a href="/admin" class="flex items-center space-x-2 px-3 py-2 rounded hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-300" fill="currentColor"><path d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-6H3v6ZM13 3v6h8V3h-8Z"/></svg>
            <span>Dashboard</span>
        </a>
        <a href="/admin/cars" class="flex items-center space-x-2 px-3 py-2 rounded hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-300" fill="currentColor"><path d="M3 16a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v3h-2v-1H5v1H3v-3Zm4-7 2-3h6l2 3H7Zm0 0"/></svg>
            <span>Quản lý Xe</span>
        </a>
        <a href="/admin/bookings" class="flex items-center space-x-2 px-3 py-2 rounded hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-300" fill="currentColor"><path d="M6 2h12v4H6V2Zm-2 6h16v14H4V8Zm4 3h8v2H8v-2Zm0 4h8v2H8v-2Z"/></svg>
            <span>Quản lý Booking</span>
        </a>
        <a href="/admin/owners" class="flex items-center space-x-2 px-3 py-2 rounded hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-300" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm-9 9a9 9 0 1 1 18 0H3Z"/></svg>
            <span>Quản lý Chủ xe</span>
        </a>
        <a href="/admin/users" class="flex items-center space-x-2 px-3 py-2 rounded hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-300" fill="currentColor"><path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4ZM4 20a6 6 0 0 1 12 0H4Zm0 0"/></svg>
            <span>Quản lý Người dùng</span>
        </a>
    </nav>
    <div class="px-4 py-4 border-t border-gray-800">
        <form method="POST" action="/admin/logout">
            @csrf
            <button class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded flex items-center justify-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M16 17v2H4V5h12v2h2V3H2v18h16v-4h-2Zm-1-6H8v2h7v3l5-4-5-4v3Z"/></svg>
                <span>Đăng xuất</span>
            </button>
        </form>
    </div>
</aside>
