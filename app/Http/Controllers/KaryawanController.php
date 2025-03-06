<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // Debugging guard session
        $guard = session('auth_guard', 'karyawan');

        if (!Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        $user = Auth::guard($guard)->user();

        // Check if the user is indeed a 'mahasiswa' (by role)
        if ($user->role !== 'karyawan') {
            // If the user is not a mahasiswa, redirect them back
            return back()->withErrors(['message' => 'You do not have access to this page.']);
        }

        // Debugging user info
        return view('karyawan.dashboard', ['user' => $user]);
    }
}
