<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user || $user->role !== $role) {
            // Jika bukan role yang sesuai, redirect ke home atau login
            return redirect('/login')->withErrors('Anda tidak memiliki akses ke halaman ini!');
        }

        return $next($request);
    }
}
