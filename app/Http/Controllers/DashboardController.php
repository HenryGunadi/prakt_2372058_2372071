<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $view = $request->query('view', 'main');
        $guard = session('auth_guard', 'mahasiswa');
        $user = Auth::guard($guard)->user();
        $surats = $user->surat;

        if ($guard !== 'mahasiswa') {
            return back()->withErrors([
                'role' => 'user is not a karyawan!',
            ]);
        }

        if (!Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        // // Check if the user is indeed a 'mahasiswa' (by role)
        // if ($user->role !== 'mahasiswa') {
        //     // If the user is not a mahasiswa, redirect them back
        //     return back()->withErrors(['message' => 'You do not have access to this page.']);
        // }

        return view('mahasiswa.dashboard', compact('user', 'view', 'surats'));
    }
}
