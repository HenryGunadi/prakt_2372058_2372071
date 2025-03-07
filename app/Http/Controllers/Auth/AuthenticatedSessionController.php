<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request, $role = null)
    {
        return view('auth.login', ['role' => $role]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $role = $request->input('role', 'mahasiswa');
        $identifierField = $role === 'mahasiswa' ? 'nrp' : 'nip';
        Log::channel('my_logs')->info("User role : " . $role);

        // Validate the request
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:mahasiswa,karyawan',
        ]);

        // Set up credentials based on role
        $credentials = [
            $identifierField => $request->input('identifier'),
            'password' => $request->input('password'),
        ];

        Log::channel('my_logs')->info("Identifier field : " . $identifierField);

        // Try to authenticate with the guard
        if (Auth::guard($role)->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::guard($role)->user();
            session(['auth_guard' => $role]); // Set the correct guard in the session
            
            // Redirect based on user role
            // Assuming your role relationship returns a model with a 'name' property
            if ($role === 'mahasiswa') {
                Log::channel('my_logs')->info("Mahasiswa true");
                
                return redirect()->route('mahasiswa.dashboard');
            } elseif ($role === 'karyawan') {
                Log::channel('my_logs')->info("Karyawan true");

                return redirect()->route('karyawan.dashboard');
            }
        }

        Log::channel('my_logs')->info("Login Failed");
        // Authentication failed
        return back()->withErrors([
            'identifier' => 'Invalid credentials.',
        ]);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $guard = session('auth_guard');
        Log::channel("my_logs")->info("Guard in logout : " . $guard);

        // Get the current guard from session (either 'mahasiswa' or 'karyawan')
        Log::channel("my_logs")->info("Logout function reached!");
        Log::channel("my_logs")->info("User: " . json_encode(Auth::user()));

        // Logout the user based on the guard
        if ($guard === 'karyawan') {
            Auth::guard('karyawan')->logout();
        } else {
            Auth::guard('mahasiswa')->logout();
        }

        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect user to homepage or desired page after logout
        Log::channel("my_logs")->info("Im here in logout");
        return redirect('/');
    }
}
