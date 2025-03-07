<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // Debugging guard session
        $guard = session('auth_guard', 'karyawan');

        if ($guard !== 'karyawan') {
            return back()->withErrors([
                'role' => 'user is not a karyawan!',
            ]);
        }

        if (!Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        $user = Auth::guard($guard)->user();
        
        // Debugging user info
        return view('karyawan.dashboard', ['user' => $user]);
    }
}
