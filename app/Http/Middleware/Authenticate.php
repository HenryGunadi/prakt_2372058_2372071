<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            # Check if guard is authenticated
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard);
                return $next($request);
            }
        }

        # Redirect unauthenticated users
        return $this->unauthenticated($request, $guards);
    }

    /**
     * Handle unauthenticated request.
     */
    protected function unauthenticated(Request $request, array $guards)
    {
        return redirect()->route($this->redirectTo($request));
    }

    /**
     * Redirect user based on route
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->is('mahasiswa/*')) {
                return 'mahasiswa.login';
            }
            if ($request->is('karyawan/*')) {
                return 'karyawan.login';
            }

            return route('register'); // Default redirect (or change to another page)
        }
    }

}
