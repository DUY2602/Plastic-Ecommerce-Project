<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectMiddleware
{
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check role if specified
        if ($role) {
            if ($role === 'admin' && $user->Role != 1) {
                return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập!');
            }

            if ($role === 'user' && $user->Role != 0) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
