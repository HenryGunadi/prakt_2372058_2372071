<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $guard = session('auth_guard', 'mahasiswa');

        if (!Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        $user = Auth::guard($guard)->user();

        // Check if the user is indeed a 'mahasiswa' (by role)
        if ($user->role !== 'mahasiswa') {
            // If the user is not a mahasiswa, redirect them back
            return back()->withErrors(['message' => 'You do not have access to this page.']);
        }

        return view('mahasiswa.dashboard', ['user' => $user]);
    }
}
