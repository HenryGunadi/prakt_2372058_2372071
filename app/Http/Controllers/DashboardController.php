<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Debugging guard session
        $guard = session('auth_guard', 'mahasiswa');

        if (!Auth::guard($guard)->check()) {
            return redirect()->route('login');
        }

        $user = Auth::guard($guard)->user();

        // Debugging user info

        if ($guard === 'mahasiswa') {
            return view('mahasiswa.dashboard', ['user' => $user]);
        } else {
            $karyawanRole = $user->role->role ?? 'Unknown Role';
            return view('karyawan.dashboard', [
                'user' => $user,
                'karyawan_role' => $karyawanRole
            ]);
        }
    }
}
