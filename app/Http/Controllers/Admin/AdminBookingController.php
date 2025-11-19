<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
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
    }
}

