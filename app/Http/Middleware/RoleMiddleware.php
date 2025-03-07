<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($role === 'mahasiswa' && Auth::guard('mahasiswa')->check()) {
            return $next($request);
        }

        if ($role === 'karyawan' && Auth::guard('karyawan')->check()) {
            return $next($request);
        }

        return redirect()->back()->withErrors(['message' => 'Unauthorized access.']); 
    }
}
