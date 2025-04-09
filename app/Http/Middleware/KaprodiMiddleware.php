<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaprodiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan pengguna sudah login dan memiliki role Kaprodi
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        // Redirect jika bukan Kaprodi
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}