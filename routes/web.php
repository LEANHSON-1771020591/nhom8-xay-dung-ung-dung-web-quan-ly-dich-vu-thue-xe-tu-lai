<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\BlogController;

// Home routes 
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);

// Auth routes 
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);

// Owner routes 
Route::get('/owner', [OwnerController::class, 'create']);
Route::post('/owner', [OwnerController::class, 'store']);
Route::get('/owner/cars/{car}/edit', [OwnerController::class, 'edit']);
Route::put('/owner/cars/{car}', [OwnerController::class, 'update']);
Route::delete('/owner/cars/{car}', [OwnerController::class, 'destroy']);

// Trip routes 
Route::get('/my-trips', [TripController::class, 'index']);
Route::post('/book/{car}', [TripController::class, 'store']);
Route::post('/bookings/{booking}/cancel', [TripController::class, 'cancel']);

Route::get('/filter/{slug}', [CategoryController::class, 'filter']);

Route::get('/car/{slug}', [CarController::class, 'show']);
Route::get('/users/{slug}', [UserController::class, 'show']);
Route::get('/blog/{blog}', [BlogController::class, 'show']);


// Admin routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm']);
Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

Route::get('/admin', [AdminDashboardController::class, 'index']);

Route::get('/admin/cars', [AdminCarController::class, 'index']);
Route::get('/admin/cars/{car}/edit', [AdminCarController::class, 'edit']);
Route::put('/admin/cars/{car}', [AdminCarController::class, 'update']);
Route::delete('/admin/cars/{car}', [AdminCarController::class, 'destroy']);

Route::get('/admin/users', [AdminUserController::class, 'index']);
Route::post('/admin/users/{user}/lock', [AdminUserController::class, 'lock']);
Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit']);
Route::put('/admin/users/{user}', [AdminUserController::class, 'update']);
Route::post('/admin/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole']);

Route::get('/admin/bookings', [AdminBookingController::class, 'index']);

// Admin blogs CRUD
Route::get('/admin/blogs', [AdminBlogController::class, 'index']);
Route::get('/admin/blogs/create', [AdminBlogController::class, 'create']);
Route::post('/admin/blogs', [AdminBlogController::class, 'store']);
Route::get('/admin/blogs/{blog}/edit', [AdminBlogController::class, 'edit']);
Route::put('/admin/blogs/{blog}', [AdminBlogController::class, 'update']);
Route::delete('/admin/blogs/{blog}', [AdminBlogController::class, 'destroy']);
