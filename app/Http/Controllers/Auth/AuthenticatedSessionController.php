<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\Console\Input\Input;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        $role = $request->query('role');

        return view('auth.login', compact('role'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $role = $request->input('role');
        $identifiedUser = $role === "mahasiswa" ? 'nrp' : 'nip';
    
        $credentials = [
            $identifiedUser => $request->input('identifier'),
            'password' => $request->input('password'),
        ];
    
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'identifier' => 'Invalid credentials.',
            ]);
        }
    
        $request->session()->put('role', $role);
        $request->session()->save();
    
        if ($role === "karyawan") {
            $user = Auth::user();
            $request->session()->put('karyawan_role', $user->role);
        }
    
        $request->session()->regenerate();
    
        return redirect()->intended(route('dashboard'));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
