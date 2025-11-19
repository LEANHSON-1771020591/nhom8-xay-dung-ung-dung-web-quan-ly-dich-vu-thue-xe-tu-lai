<?php

use Illuminate\Support\Facades\Route;
use App\Models\Car;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\HomeController;

// Home routes - sử dụng HomeController
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);

Route::get('/owner', function () {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Vui lòng đăng nhập để đăng ký xe');
    }
    return view('owner.index');
});

Route::post('/owner', function (Request $req) {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Vui lòng đăng nhập để đăng ký xe');
    }
    $userId = Auth::id();
    $validated = $req->validate([
        'model' => 'required|string|min:2',
        'address' => 'required|string|min:2',
        'location' => 'required|string',
        'price' => 'required|integer|min:1',
        'seat' => 'required|integer|min:4',
        'transmission' => 'required|in:AT,MT',
        'fuel' => 'required|in:Xăng,Dầu,Điện',
        'images' => 'required|array|size:4',
        'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120',
        'desc' => 'required|string|min:10',
    ]);
    $slug = Str::slug($validated['model']).'-'.Str::random(6);
    $paths = [];
    foreach ($req->file('images') as $file) {
        $paths[] = $file->store('cars', 'public');
    }
    $car = Car::create([
        'model' => $validated['model'],
        'address' => $validated['address'],
        'location' => $validated['location'],
        'price' => (string)$validated['price'],
        'images' => $paths,
        'desc' => $validated['desc'],
        'trip' => 0,
        'transmission' => $validated['transmission'],
        'seat' => (int)$validated['seat'],
        'fuel' => $validated['fuel'],
        'consumed' => '—',
        'owner_id' => $userId,
        'slug' => $slug,
    ]);
    return redirect('/car/'.$car->slug)->with('success', 'Đã đăng ký xe thành công');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', function (Request $req) {
    $credentials = $req->only('email', 'password');
    if (!Auth::attempt($credentials)) {
        return redirect()->back()->with('error', 'Thông tin đăng nhập không đúng');
    }
    if (Auth::user()->is_locked ?? false) {
        Auth::logout();
        return redirect()->back()->with('error', 'Tài khoản đã bị khóa');
    }
    $req->session()->regenerate();
    return redirect('/my-trips');
});

Route::post('/logout', function (Request $req) {
    Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();
    return redirect('/');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', function (Request $req) {
    $req->validate([
        'username' => 'required|string|min:2',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
    ]);
    $user = User::create([
        'name' => $req->input('username'),
        'email' => $req->input('email'),
        'password' => bcrypt($req->input('password')),
        'avatar' => 'https://via.placeholder.com/80',
        'slug' => Str::slug($req->input('username')),
    ]);
    Auth::login($user);
    return redirect('/my-trips');
});

Route::get("/filter/{slug}", function ($slug) {
    $query = Car::where("location", $slug)->where('status','approved');
    $min = request('min_price');
    $max = request('max_price');
    $transmission = request('transmission');
    $seat = request('seat');
    $fuel = request('fuel');
    $model = request('model');
    if ($min !== null) {
        $query->whereRaw('CAST(price AS UNSIGNED) >= ?', [(int)$min]);
    }
    if ($max !== null) {
        $query->whereRaw('CAST(price AS UNSIGNED) <= ?', [(int)$max]);
    }
    if ($transmission !== null && $transmission !== '') {
        $query->where('transmission', $transmission);
    }
    if ($seat !== null && $seat !== '') {
        $query->where('seat', (int)$seat);
    }
    if ($fuel !== null && $fuel !== '') {
        $query->where('fuel', $fuel);
    }
    if ($model !== null && $model !== '') {
        $query->where('model', 'like', '%'.$model.'%');
    }
    $cars = $query->get();
    return view("category.index", compact(["slug", "cars"]));
});

Route::get("/car/{slug}", function ($slug) {
    $car = Car::where("slug", $slug)->first();
    if (!$car) {
        return redirect('/')->with('error', 'Xe không tồn tại');
    }
    return view("car.show", compact("car"));
});

Route::get('/my-trips', function () {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Vui lòng đăng nhập để xem chuyến của bạn');
    }
    $userId = Auth::id();
    $bookings = Booking::with('car')->where('user_id', $userId)->orderBy('start_date', 'desc')->get();
    $today = Carbon::today()->toDateString();
    $ongoing = $bookings->filter(fn($b) => $b->status === 'confirmed' && $b->start_date <= $today && $b->end_date >= $today);
    $past = $bookings->filter(fn($b) => $b->end_date < $today || $b->status === 'cancelled');
    $dailyTotal = $ongoing->sum('daily_price');
    $ownedCars = Car::where('owner_id', $userId)->get();
    return view('trips.index', compact('bookings', 'dailyTotal', 'ongoing', 'past', 'ownedCars'));
});

Route::post('/book/{car}', function (Car $car) {
    if (!Auth::check()) {
        return redirect()->back()->with('error', 'Vui lòng đăng nhập để thuê xe');
    }
    $userId = Auth::id();
    if ($car->owner_id == $userId) {
        return redirect()->back()->with('error', 'Bạn không thể thuê xe của chính mình');
    }
    $start = Carbon::today()->toDateString();
    $end = request('end_date');
    if (!$end) {
        return redirect()->back()->with('error', 'Vui lòng chọn ngày kết thúc');
    }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $end)) {
        return redirect()->back()->with('error', 'Ngày kết thúc không hợp lệ');
    }
    try {
        $endDate = Carbon::createFromFormat('Y-m-d', $end);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Ngày kết thúc không hợp lệ');
    }
    if ($endDate->lt(Carbon::today())) {
        return redirect()->back()->with('error', 'Ngày kết thúc phải từ hôm nay trở đi');
    }
    $maxDate = Carbon::today()->addYears(2);
    if ($endDate->gt($maxDate)) {
        return redirect()->back()->with('error', 'Ngày kết thúc không được quá 2 năm kể từ hôm nay');
    }
    $end = $endDate->toDateString();
    $overlap = Booking::where('car_id', $car->id)
        ->where('status', 'confirmed')
        ->where('start_date', '<=', $end)
        ->where('end_date', '>=', $start)
        ->exists();
    if ($overlap) {
        return redirect()->back()->with('error', 'Xe đang được thuê trong khoảng thời gian đã chọn');
    }
    Booking::create([
        'user_id' => $userId,
        'car_id' => $car->id,
        'start_date' => $start,
        'end_date' => $end,
        'daily_price' => (int)$car->price,
        'status' => 'confirmed',
    ]);
    return redirect('/my-trips')->with('success', 'Đã đặt xe thành công');
});

Route::post('/bookings/{booking}/cancel', function (Booking $booking) {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Vui lòng đăng nhập');
    }
    $userId = Auth::id();
    if ($booking->user_id !== $userId) {
        return redirect()->back()->with('error', 'Không thể hủy chuyến của người khác');
    }
    $booking->status = 'cancelled';
    $booking->save();
    return redirect('/my-trips')->with('success', 'Đã hủy chuyến thành công');
});

Route::get('/owner/cars/{car}/edit', function (Car $car) {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Vui lòng đăng nhập');
    }
    $userId = Auth::id();
    if ($car->owner_id !== $userId) {
        return redirect('/my-trips')->with('error', 'Bạn không thể sửa xe của người khác');
    }
    return view('owner.index', compact('car'));
});

Route::put('/owner/cars/{car}', function (Request $req, Car $car) {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Vui lòng đăng nhập');
    }
    $userId = Auth::id();
    if ($car->owner_id !== $userId) {
        return redirect('/my-trips')->with('error', 'Bạn không thể sửa xe của người khác');
    }
    $validated = $req->validate([
        'model' => 'required|string|min:2',
        'address' => 'required|string|min:2',
        'location' => 'required|string',
        'price' => 'required|integer|min:1',
        'seat' => 'required|integer|min:4',
        'transmission' => 'required|in:AT,MT',
        'fuel' => 'required|in:Xăng,Dầu,Điện',
        'images' => 'nullable|array',
        'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120',
        'desc' => 'required|string|min:10',
    ]);
    $paths = null;
    if ($req->hasFile('images')) {
        $paths = [];
        foreach ($req->file('images') as $file) {
            $paths[] = $file->store('cars', 'public');
        }
    }
    $car->model = $validated['model'];
    $car->address = $validated['address'];
    $car->location = $validated['location'];
    $car->price = (string)$validated['price'];
    if ($paths !== null) {
        $car->images = $paths;
    }
    $car->desc = $validated['desc'];
    $car->transmission = $validated['transmission'];
    $car->seat = (int)$validated['seat'];
    $car->fuel = $validated['fuel'];
    $car->save();
    return redirect('/car/'.$car->slug)->with('success', 'Đã cập nhật xe thành công');
});

Route::delete('/owner/cars/{car}', function (Car $car) {
    if (!Auth::check()) {
        return redirect('/login')->with('error', 'Vui lòng đăng nhập');
    }
    $userId = Auth::id();
    if ($car->owner_id !== $userId) {
        return redirect('/my-trips')->with('error', 'Bạn không thể xóa xe của người khác');
    }
    $car->delete();
    return redirect('/my-trips')->with('success', 'Đã xóa xe thành công');
});
// Admin auth
Route::get('/admin/login', function () {
    return view('admin.auth.login');
});

Route::post('/admin/login', function (Request $req) {
    $credentials = $req->only('email', 'password');
    if (!Auth::attempt($credentials)) {
        return redirect()->back()->with('error', 'Thông tin đăng nhập không đúng');
    }
    if (Auth::user()->is_locked ?? false) {
        Auth::logout();
        return redirect()->back()->with('error', 'Tài khoản đã bị khóa');
    }
    if (Auth::user()->role !== 'admin') {
        Auth::logout();
        return redirect()->back()->with('error', 'Tài khoản không có quyền Admin');
    }
    $req->session()->regenerate();
    return redirect('/admin');
});

Route::get('/admin/register', function () {
    return view('admin.auth.register');
});

Route::post('/admin/register', function (Request $req) {
    $req->validate([
        'username' => 'required|string|min:2',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
    ]);
    $user = User::create([
        'name' => $req->input('username'),
        'email' => $req->input('email'),
        'password' => bcrypt($req->input('password')),
        'avatar' => 'https://via.placeholder.com/80',
        'slug' => Str::slug($req->input('username')),
        'role' => 'admin',
    ]);
    Auth::login($user);
    return redirect('/admin');
});

Route::post('/admin/logout', function (Request $req) {
    Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();
    return redirect('/admin/login');
});

// Admin area
Route::get('/admin', function () {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $today = Carbon::today()->toDateString();
    $usersCount = User::count();
    $carsCount = Car::count();
    $bookingsCount = Booking::count();
    $dailyBookings = Booking::whereDate('created_at', $today)->count();
    $weeklyBookings = Booking::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
    $monthlyBookings = Booking::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
    $recentBookings = Booking::with(['car','user'])->orderBy('created_at','desc')->take(5)->get();
    $topOwners = User::withCount('cars')->orderBy('cars_count','desc')->take(5)->get();
    $activeUsers = User::withCount(['bookings as recent_bookings_count' => function ($q) {
        $q->where('status', 'confirmed')
          ->whereDate('created_at', '>=', Carbon::now()->subDays(30));
    }])->orderBy('recent_bookings_count','desc')->take(5)->get();
    return view('admin.dashboard', compact('usersCount','carsCount','bookingsCount','dailyBookings','weeklyBookings','monthlyBookings','recentBookings','topOwners','activeUsers'));
});

Route::get('/admin/cars', function () {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $status = null;
    $location = request('location');
    $owner = request('owner');
    $model = request('model');
    $transmission = request('transmission');
    $seat = request('seat');
    $fuel = request('fuel');
    $min = request('min_price');
    $max = request('max_price');
    $query = Car::query();
    
    if ($location) $query->where('location', $location);
    if ($owner) $query->where('owner_id', (int)$owner);
    if ($model) $query->where('model','like','%'.$model.'%');
    if ($transmission) $query->where('transmission',$transmission);
    if ($seat) $query->where('seat',(int)$seat);
    if ($fuel) $query->where('fuel',$fuel);
    if ($min !== null && $min !== '') $query->whereRaw('CAST(price AS UNSIGNED) >= ?', [(int)$min]);
    if ($max !== null && $max !== '') $query->whereRaw('CAST(price AS UNSIGNED) <= ?', [(int)$max]);
    $cars = $query->orderBy('created_at','desc')->get();
    $owners = User::whereHas('cars')->get();
    return view('admin.cars.index', compact('cars','owners'));
});

// Bỏ luồng cập nhật trạng thái duyệt xe

// Admin Cars CRUD
Route::get('/admin/cars/create', function () {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    return view('admin.cars.create');
});

Route::post('/admin/cars', function (Request $req) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $validated = $req->validate([
        'model' => 'required|string|min:2',
        'address' => 'required|string|min:2',
        'location' => 'required|string',
        'price' => 'required|integer|min:1',
        'seat' => 'required|integer|min:4',
        'transmission' => 'required|in:AT,MT',
        'fuel' => 'required|in:Xăng,Dầu,Điện',
        'images' => 'required|array|size:4',
        'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120',
        'desc' => 'required|string|min:10',
        'owner_id' => 'required|integer|exists:users,id',
    ]);
    $paths = [];
    foreach ($req->file('images') as $file) {
        $paths[] = $file->store('cars', 'public');
    }
    $slug = Str::slug($validated['model']).'-'.Str::random(6);
    $car = Car::create([
        'model' => $validated['model'],
        'address' => $validated['address'],
        'location' => $validated['location'],
        'price' => (string)$validated['price'],
        'images' => $paths,
        'desc' => $validated['desc'],
        'trip' => 0,
        'transmission' => $validated['transmission'],
        'seat' => (int)$validated['seat'],
        'fuel' => $validated['fuel'],
        'consumed' => '—',
        'owner_id' => (int)$validated['owner_id'],
        'slug' => $slug,
    ]);
    return redirect('/admin/cars')->with('success','Đã tạo xe mới');
});

Route::get('/admin/cars/{car}/edit', function (Car $car) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    return view('admin.cars.edit', compact('car'));
});

Route::put('/admin/cars/{car}', function (Request $req, Car $car) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $validated = $req->validate([
        'model' => 'required|string|min:2',
        'address' => 'required|string|min:2',
        'location' => 'required|string',
        'price' => 'required|integer|min:1',
        'seat' => 'required|integer|min:4',
        'transmission' => 'required|in:AT,MT',
        'fuel' => 'required|in:Xăng,Dầu,Điện',
        'images' => 'nullable|array',
        'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120',
        'desc' => 'required|string|min:10',
        'owner_id' => 'required|integer|exists:users,id',
    ]);
    $paths = null;
    if ($req->hasFile('images')) {
        $paths = [];
        foreach ($req->file('images') as $file) {
            $paths[] = $file->store('cars', 'public');
        }
    }
    $car->model = $validated['model'];
    $car->address = $validated['address'];
    $car->location = $validated['location'];
    $car->price = (string)$validated['price'];
    if ($paths !== null) $car->images = $paths;
    $car->desc = $validated['desc'];
    $car->transmission = $validated['transmission'];
    $car->seat = (int)$validated['seat'];
    $car->fuel = $validated['fuel'];
    $car->owner_id = (int)$validated['owner_id'];
    $car->save();
    return redirect('/admin/cars')->with('success','Đã cập nhật xe');
});

Route::delete('/admin/cars/{car}', function (Car $car) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $car->delete();
    return redirect('/admin/cars')->with('success','Đã xóa xe');
});

Route::get('/admin/owners', function () {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $owners = User::withCount('cars')->whereHas('cars')->get();
    return view('admin.owners.index', compact('owners'));
});

Route::get('/admin/users', function () {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $users = User::orderBy('created_at','desc')->get();
    return view('admin.users.index', compact('users'));
});

Route::post('/admin/users/{user}/lock', function (User $user) {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $user->is_locked = true;
    $user->save();
    return redirect()->back()->with('success','Đã khóa tài khoản người dùng');
});

Route::get('/admin/bookings', function () {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/admin/login');
    }
    $status = request('status');
    $from = request('from');
    $to = request('to');
    $query = Booking::with(['car','user'])->orderBy('created_at','desc');
    if ($status) $query->where('status',$status);
    if ($from) $query->whereDate('created_at','>=',$from);
    if ($to) $query->whereDate('created_at','<=',$to);
    $bookings = $query->get();
    return view('admin.bookings.index', compact('bookings'));
});
