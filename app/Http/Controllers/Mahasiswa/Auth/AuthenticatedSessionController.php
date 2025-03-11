<?php

namespace App\Http\Controllers\Mahasiswa\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MahasiswaLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('mahasiswa.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(MahasiswaLoginRequest $request): RedirectResponse
    {
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $request->authenticate();

        $request->session()->regenerate();

        Log::channel("my_logs")->info("Login success as mahasiswa");
        return redirect()->intended(route('mahasiswa.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('mahasiswa')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('mahasiswa.login');
    }
}
