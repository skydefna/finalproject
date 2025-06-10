<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class Authenticate
{
    /**
     * Menangani request yang masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // Jika pengguna sudah terautentikasi, lanjutkan request
            return $next($request);
        }

        // Jika pengguna tidak terautentikasi, lemparkan pengecualian atau redirect ke login
        throw new AuthenticationException('Unauthenticated.');
    }
}
