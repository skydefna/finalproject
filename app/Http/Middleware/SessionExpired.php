<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionExpired
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !$request->session()->has('_token')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('loginError', 'Sesi Anda telah berakhir karena tidak ada aktivitas.');
        }

        return $next($request);
    }
}

