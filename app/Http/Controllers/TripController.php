<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TripController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để xem chuyến của bạn');
        }
        
        $userId = Auth::id();
        
        $bookings = Booking::with('car')
            ->where('user_id', $userId)
            ->orderBy('start_date', 'desc')
            ->get();
        
        $today = Carbon::today()->toDateString();
        
        $ongoing = $bookings->filter(function ($booking) use ($today) {
            return $booking->status === 'confirmed' 
                && $booking->start_date <= $today 
                && $booking->end_date >= $today;
        });
        
        $past = $bookings->filter(function ($booking) use ($today) {
            return $booking->end_date < $today || $booking->status === 'cancelled';
        });
        
        $dailyTotal = $ongoing->sum('daily_price');
        $ownedCars = Car::where('owner_id', $userId)->get();
        
        return view('trips.index', compact('bookings', 'dailyTotal', 'ongoing', 'past', 'ownedCars'));
    }

    public function store(Request $request, Car $car)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để thuê xe');
        }
        
        $userId = Auth::id();
        
        if ($car->owner_id == $userId) {
            return redirect()->back()->with('error', 'Bạn không thể thuê xe của chính mình');
        }
        
        $start = Carbon::today()->toDateString();
        $end = $request->input('end_date');
        
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
    }

    public function cancel(Booking $booking)
    {
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
    }
}
