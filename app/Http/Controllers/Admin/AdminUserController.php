<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        $users = User::orderBy('created_at','desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function lock(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        $user->is_locked = true;
        $user->save();
        return redirect()->back()->with('success','Đã khóa tài khoản người dùng');
    }

    public function edit(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|url',
            'role' => 'required|in:user,admin',
            'is_locked' => 'boolean',
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->avatar = $validated['avatar'] ?? $user->avatar;
        $user->role = $validated['role'];
        $user->is_locked = $request->has('is_locked') ? true : false;
        $user->save();
        
        return redirect('/admin/users')->with('success', 'Đã cập nhật thông tin người dùng');
    }

    public function toggleRole(User $user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        // Không cho phép admin tự thay đổi vai trò của chính mình
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Không thể thay đổi vai trò của chính bạn');
        }
        
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();
        
        return redirect()->back()->with('success', 'Đã thay đổi vai trò thành '.($user->role === 'admin' ? 'Admin' : 'User'));
    }
}

