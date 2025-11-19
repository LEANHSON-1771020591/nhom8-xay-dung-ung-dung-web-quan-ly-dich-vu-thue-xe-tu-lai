<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * OwnerController
 * 
 * Controller xử lý các route liên quan đến chủ xe:
 * - Đăng ký xe mới
 * - Sửa thông tin xe
 * - Xóa xe
 */
class OwnerController extends Controller
{
    /**
     * Hiển thị form đăng ký xe mới
     * 
     * Yêu cầu người dùng phải đăng nhập
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để đăng ký xe');
        }
        
        // Hiển thị form đăng ký xe
        return view('owner.index');
    }

    /**
     * Xử lý đăng ký xe mới
     * 
     * Validate thông tin, upload ảnh và tạo xe mới
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để đăng ký xe');
        }
        
        // Lấy ID của người dùng hiện tại
        $userId = Auth::id();
        
        // Validate thông tin đầu vào
        $validated = $request->validate([
            'model' => 'required|string|min:2', // Tên xe, tối thiểu 2 ký tự
            'address' => 'required|string|min:2', // Địa chỉ, tối thiểu 2 ký tự
            'location' => 'required|string', // Vị trí (thành phố)
            'price' => 'required|integer|min:1', // Giá thuê, phải là số nguyên dương
            'seat' => 'required|integer|min:4', // Số ghế, tối thiểu 4
            'transmission' => 'required|in:AT,MT', // Hộp số: AT (tự động) hoặc MT (số sàn)
            'fuel' => 'required|in:Xăng,Dầu,Điện', // Nhiên liệu
            'images' => 'required|array|size:4', // Phải có đúng 4 ảnh
            'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120', // Mỗi ảnh tối đa 5MB
            'desc' => 'required|string|min:10', // Mô tả, tối thiểu 10 ký tự
        ]);
        
        // Tạo slug từ tên xe kèm chuỗi ngẫu nhiên để đảm bảo unique
        $slug = Str::slug($validated['model']) . '-' . Str::random(6);
        
        // Upload và lưu đường dẫn các ảnh
        $paths = [];
        foreach ($request->file('images') as $file) {
            $paths[] = $file->store('cars', 'public');
        }
        
        // Tạo xe mới trong database
        $car = Car::create([
            'model' => $validated['model'],
            'address' => $validated['address'],
            'location' => $validated['location'],
            'price' => (string)$validated['price'], // Chuyển sang string để lưu
            'images' => $paths, // Lưu mảng đường dẫn ảnh
            'desc' => $validated['desc'],
            'trip' => 0, // Số chuyến ban đầu = 0
            'transmission' => $validated['transmission'],
            'seat' => (int)$validated['seat'],
            'fuel' => $validated['fuel'],
            'consumed' => '—', // Mức tiêu thụ mặc định
            'owner_id' => $userId, // ID của chủ xe
            'slug' => $slug,
        ]);
        
        // Chuyển hướng đến trang chi tiết xe với thông báo thành công
        return redirect('/car/' . $car->slug)->with('success', 'Đã đăng ký xe thành công');
    }

    /**
     * Hiển thị form sửa thông tin xe
     * 
     * Chỉ chủ xe mới có quyền sửa xe của mình
     * 
     * @param \App\Models\Car $car
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Car $car)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }
        
        // Lấy ID của người dùng hiện tại
        $userId = Auth::id();
        
        // Kiểm tra quyền sở hữu: chỉ chủ xe mới được sửa
        if ($car->owner_id !== $userId) {
            return redirect('/my-trips')->with('error', 'Bạn không thể sửa xe của người khác');
        }
        
        // Hiển thị form sửa với dữ liệu xe hiện tại
        return view('owner.index', compact('car'));
    }

    /**
     * Xử lý cập nhật thông tin xe
     * 
     * Validate thông tin, upload ảnh mới (nếu có) và cập nhật xe
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Car $car
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Car $car)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }
        
        // Lấy ID của người dùng hiện tại
        $userId = Auth::id();
        
        // Kiểm tra quyền sở hữu: chỉ chủ xe mới được sửa
        if ($car->owner_id !== $userId) {
            return redirect('/my-trips')->with('error', 'Bạn không thể sửa xe của người khác');
        }
        
        // Validate thông tin đầu vào (ảnh là optional khi sửa)
        $validated = $request->validate([
            'model' => 'required|string|min:2',
            'address' => 'required|string|min:2',
            'location' => 'required|string',
            'price' => 'required|integer|min:1',
            'seat' => 'required|integer|min:4',
            'transmission' => 'required|in:AT,MT',
            'fuel' => 'required|in:Xăng,Dầu,Điện',
            'images' => 'nullable|array', // Ảnh là optional khi sửa
            'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120',
            'desc' => 'required|string|min:10',
        ]);
        
        // Xử lý upload ảnh mới (nếu có)
        $paths = null;
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('cars', 'public');
            }
        }
        
        // Cập nhật thông tin xe
        $car->model = $validated['model'];
        $car->address = $validated['address'];
        $car->location = $validated['location'];
        $car->price = (string)$validated['price'];
        
        // Chỉ cập nhật ảnh nếu có ảnh mới được upload
        if ($paths !== null) {
            $car->images = $paths;
        }
        
        $car->desc = $validated['desc'];
        $car->transmission = $validated['transmission'];
        $car->seat = (int)$validated['seat'];
        $car->fuel = $validated['fuel'];
        
        // Lưu thay đổi
        $car->save();
        
        // Chuyển hướng đến trang chi tiết xe với thông báo thành công
        return redirect('/car/' . $car->slug)->with('success', 'Đã cập nhật xe thành công');
    }

    /**
     * Xử lý xóa xe
     * 
     * Chỉ chủ xe mới có quyền xóa xe của mình
     * 
     * @param \App\Models\Car $car
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Car $car)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }
        
        // Lấy ID của người dùng hiện tại
        $userId = Auth::id();
        
        // Kiểm tra quyền sở hữu: chỉ chủ xe mới được xóa
        if ($car->owner_id !== $userId) {
            return redirect('/my-trips')->with('error', 'Bạn không thể xóa xe của người khác');
        }
        
        // Xóa xe khỏi database
        $car->delete();
        
        // Chuyển hướng về trang "Xe của tôi" với thông báo thành công
        return redirect('/my-trips')->with('success', 'Đã xóa xe thành công');
    }
}

