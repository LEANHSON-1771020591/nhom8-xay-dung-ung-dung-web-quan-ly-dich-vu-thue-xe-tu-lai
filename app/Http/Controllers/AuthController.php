<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * AuthController
 * 
 * Controller xử lý các route liên quan đến xác thực người dùng:
 * - Đăng nhập (login)
 * - Đăng ký (register)
 * - Đăng xuất (logout)
 */
class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     * 
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     * 
     * Kiểm tra thông tin đăng nhập, xác thực tài khoản và đăng nhập người dùng
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Lấy thông tin email và password từ request
        $credentials = $request->only('email', 'password');
        
        // Thử đăng nhập với thông tin đã cung cấp
        if (!Auth::attempt($credentials)) {
            // Nếu đăng nhập thất bại, quay lại trang đăng nhập với thông báo lỗi
            return redirect()->back()->with('error', 'Thông tin đăng nhập không đúng');
        }
        
        // Kiểm tra xem tài khoản có bị khóa không
        if (Auth::user()->is_locked ?? false) {
            // Nếu tài khoản bị khóa, đăng xuất và quay lại với thông báo lỗi
            Auth::logout();
            return redirect()->back()->with('error', 'Tài khoản đã bị khóa');
        }
        
        // Tạo lại session để tránh session fixation attack
        $request->session()->regenerate();
        
        // Chuyển hướng đến trang "Xe của tôi" sau khi đăng nhập thành công
        return redirect('/my-trips');
    }

    /**
     * Xử lý đăng xuất
     * 
     * Đăng xuất người dùng, vô hiệu hóa session và tạo lại CSRF token
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Đăng xuất người dùng
        Auth::logout();
        
        // Vô hiệu hóa session hiện tại
        $request->session()->invalidate();
        
        // Tạo lại CSRF token mới
        $request->session()->regenerateToken();
        
        // Chuyển hướng về trang chủ
        return redirect('/');
    }

    /**
     * Hiển thị form đăng ký
     * 
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký tài khoản mới
     * 
     * Validate thông tin, tạo tài khoản mới và tự động đăng nhập người dùng
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate thông tin đăng ký
        $request->validate([
            'username' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);
        
        // Tạo tài khoản người dùng mới
        $user = User::create([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Mã hóa mật khẩu
            'avatar' => 'https://via.placeholder.com/80', // Avatar mặc định
            'slug' => Str::slug($request->input('username')), // Tạo slug từ username
        ]);
        
        // Tự động đăng nhập người dùng sau khi đăng ký thành công
        Auth::login($user);
        
        // Chuyển hướng đến trang "Xe của tôi"
        return redirect('/my-trips');
    }
}

