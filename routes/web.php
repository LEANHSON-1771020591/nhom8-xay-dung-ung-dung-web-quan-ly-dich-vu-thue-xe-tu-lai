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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBookingController;

// Home routes - sử dụng HomeController
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);

// Auth routes - sử dụng AuthController
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

// Owner routes - sử dụng OwnerController
Route::get('/owner', [OwnerController::class, 'create']);
Route::post('/owner', [OwnerController::class, 'store']);
Route::get('/owner/cars/{car}/edit', [OwnerController::class, 'edit']);
Route::put('/owner/cars/{car}', [OwnerController::class, 'update']);
Route::delete('/owner/cars/{car}', [OwnerController::class, 'destroy']);

// Trip routes - sử dụng TripController
Route::get('/my-trips', [TripController::class, 'index']);
Route::post('/book/{car}', [TripController::class, 'store']);
Route::post('/bookings/{booking}/cancel', [TripController::class, 'cancel']);

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


// Admin routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm']);
Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

Route::get('/admin', [AdminDashboardController::class, 'index']);

Route::get('/admin/cars', [AdminCarController::class, 'index']);
Route::get('/admin/cars/create', [AdminCarController::class, 'create']);
Route::post('/admin/cars', [AdminCarController::class, 'store']);
Route::get('/admin/cars/{car}/edit', [AdminCarController::class, 'edit']);
Route::put('/admin/cars/{car}', [AdminCarController::class, 'update']);
Route::delete('/admin/cars/{car}', [AdminCarController::class, 'destroy']);

Route::get('/admin/users', [AdminUserController::class, 'index']);
Route::get('/admin/owners', [AdminUserController::class, 'owners']);
Route::post('/admin/users/{user}/lock', [AdminUserController::class, 'lock']);

Route::get('/admin/bookings', [AdminBookingController::class, 'index']);
