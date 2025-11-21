<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trở thành chủ xe - Vato</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-nav></x-nav>

    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">Trở thành chủ xe</h1>
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            @php($isEdit = isset($car))
            <form method="POST" action="{{ $isEdit ? url('/owner/cars/' . $car->id) : url('/owner') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-3 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Model</label>
                    <input type="text" name="model" value="{{ old('model', $isEdit ? $car->model : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                    @error('model')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Địa chỉ</label>
                        <input type="text" name="address" value="{{ old('address', $isEdit ? $car->address : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        @error('address')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Thành phố (slug)</label>
                        <select name="location" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            @php($loc = old('location', $isEdit ? $car->location : ''))
                            <option value="ho-chi-minh" {{ $loc==='ho-chi-minh' ? 'selected' : '' }}>Ho Chi Minh</option>
                            <option value="ha-noi" {{ $loc==='ha-noi' ? 'selected' : '' }}>Ha Noi</option>
                            <option value="da-nang" {{ $loc==='da-nang' ? 'selected' : '' }}>Da Nang</option>
                            <option value="hai-phong" {{ $loc==='hai-phong' ? 'selected' : '' }}>Hai Phong</option>
                            <option value="thanh-hoa" {{ $loc==='thanh-hoa' ? 'selected' : '' }}>Thanh Hoa</option>
                        </select>
                        @error('location')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Giá (K/ngày)</label>
                        <input type="number" name="price" min="1" value="{{ old('price', $isEdit ? (int)$car->price : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        @error('price')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Số ghế</label>
                        <input type="number" name="seat" min="4" value="{{ old('seat', $isEdit ? (int)$car->seat : '') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                        @error('seat')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Truyền động</label>
                        <select name="transmission" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            @php($tran = old('transmission', $isEdit ? $car->transmission : ''))
                            <option value="AT" {{ $tran==='AT' ? 'selected' : '' }}>AT</option>
                            <option value="MT" {{ $tran==='MT' ? 'selected' : '' }}>MT</option>
                        </select>
                        @error('transmission')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nhiên liệu</label>
                        <select name="fuel" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                            @php($f = old('fuel', $isEdit ? $car->fuel : ''))
                            <option value="Xăng" {{ $f==='Xăng' ? 'selected' : '' }}>Xăng</option>
                            <option value="Dầu" {{ $f==='Dầu' ? 'selected' : '' }}>Dầu</option>
                            <option value="Điện" {{ $f==='Điện' ? 'selected' : '' }}>Điện</option>
                        </select>
                        @error('fuel')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Hình ảnh xe (bắt buộc 4 ảnh khi tạo mới)</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <input type="file" name="images[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" {{ $isEdit ? '' : 'required' }}>
                            <input type="file" name="images[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" {{ $isEdit ? '' : 'required' }}>
                            <input type="file" name="images[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" {{ $isEdit ? '' : 'required' }}>
                            <input type="file" name="images[]" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2" {{ $isEdit ? '' : 'required' }}>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Mỗi ô chọn một ảnh; cần đủ 4 ảnh.</p>
                        @error('images')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Mô tả</label>
                    <textarea name="desc" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>{{ old('desc', $isEdit ? $car->desc : '') }}</textarea>
                    @error('desc')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg hover:bg-green-700">Đăng ký xe</button>
                @if(session('error'))
                    <div class="text-sm text-red-600">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="text-sm text-green-600">{{ session('success') }}</div>
                @endif
            </form>
        </div>
    </section>

</body>
</html>
