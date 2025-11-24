<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutIfAdminMode
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('admin*')) {
            if (session('admin_mode') === true && Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login')->with('error', 'Phiên người dùng đã đăng xuất do đăng nhập Admin');
            }
        }
        return $next($request);
    }
}

