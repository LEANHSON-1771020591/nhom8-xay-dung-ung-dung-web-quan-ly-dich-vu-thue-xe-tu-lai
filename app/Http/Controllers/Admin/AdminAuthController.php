<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
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
        
        $request->session()->regenerate();
        $request->session()->put('admin_mode', true);
        return redirect(url('/admin'));
    }

    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);
        
        $user = User::create([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'avatar' => 'https://via.placeholder.com/80',
            'slug' => Str::slug($request->input('username')),
            'role' => 'admin',
            'is_locked' => false,
        ]);
        
        Auth::login($user);
        $request->session()->put('admin_mode', true);
        return redirect(url('/admin'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('admin_mode');
        return redirect(url('/admin/login'));
    }
}
