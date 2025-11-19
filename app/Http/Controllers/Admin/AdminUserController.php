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

    public function owners()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        $owners = User::withCount('cars')->whereHas('cars')->get();
        return view('admin.owners.index', compact('owners'));
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
}

