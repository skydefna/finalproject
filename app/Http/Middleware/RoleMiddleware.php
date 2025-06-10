<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, \Closure $next, $role)
    {
        $user = Auth::user();
        $user = Auth::user()->load('role');

        if (!$user || !$user->role || $user->role->nama !== $role) {
            Auth::logout(); // Logout user
            session()->invalidate(); // Invalidate session
            session()->regenerateToken(); // Regenerate CSRF token

            return redirect()->route('login')
                ->with('error', 'Akses ditolak. Anda masih di ' . optional($user->role)->nama);
        }

        return $next($request);
    }

}