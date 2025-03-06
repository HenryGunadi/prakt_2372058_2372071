<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        // Attempt authentication with appropriate guard
        if (Auth::guard($role)->attempt($credentials, $request->boolean('remember'))) {

            // Regenerate session
            $request->session()->regenerate();

            // Store the active guard in session
            $request->session()->put('auth_guard', $role);

            // Redirect to dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Authentication failed
        return back()
            ->withInput($request->only('identifier', 'remember'))
            ->withErrors([
                'identifier' => 'The provided credentials do not match our records.',
            ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get the current guard from session (either 'mahasiswa' or 'karyawan')
        $guard = session('auth_guard', 'mahasiswa');

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
        return redirect('/');
    }
}
