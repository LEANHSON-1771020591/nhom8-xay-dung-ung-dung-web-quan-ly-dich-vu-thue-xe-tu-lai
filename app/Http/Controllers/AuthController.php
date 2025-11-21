<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
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
        
        $request->session()->regenerate();
        return redirect('/my-trips');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
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
            'role' => 'user',
            'is_locked' => false,
        ]);
        
        Auth::login($user);
        return redirect('/my-trips');
    }
}
