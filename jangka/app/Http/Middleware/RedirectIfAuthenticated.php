<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Jika admin yang login → redirect ke admin dashboard
                if (Auth::user()->role === 'admin') {
                    return redirect('/admin/dashboard');
                }
                // Jika user biasa → redirect ke dashboard user
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
