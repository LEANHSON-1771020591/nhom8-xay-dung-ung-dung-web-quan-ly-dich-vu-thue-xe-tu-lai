<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
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
    }
}

