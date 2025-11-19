<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

/**
 * HomeController
 * 
 * Controller xử lý các route liên quan đến trang chủ và trang giới thiệu
 */
class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ
     * 
     * Lấy 8 xe đã được duyệt (status = 'approved') để hiển thị trên trang chủ
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Lấy 8 xe đầu tiên có status là 'approved'
        $cars = Car::where('status', 'approved')->take(8)->get();
        
        // Trả về view index với dữ liệu cars
        return view('index', compact('cars'));
    }

    /**
     * Hiển thị trang giới thiệu
     * 
     * @return \Illuminate\View\View
     */
    public function about()
    {
        // Trả về view about
        return view('about.index');
    }
}

