<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnforceAdminMode
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin*')) {
            if ($request->is('admin/login') || $request->is('admin/register') || $request->is('admin/logout')) {
                return $next($request);
            }
            if (session('admin_mode') !== true) {
                if (Auth::check()) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                }
                return redirect('/admin/login');
            }
        }
        return $next($request);
    }
}
