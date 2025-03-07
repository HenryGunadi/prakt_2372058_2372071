<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $guard = session('auth_guard', 'mahasiswa');
        Log::channel("my_logs")->info("auth guard : " . $guard);

        if ($guard !== 'mahasiswa') {
            return back()->withErrors([
                'role' => 'user is not a karyawan!',
            ]);
        }

        if (!Auth::guard($guard)->check()) {
            return redirect()->route('home');
        }

        $user = Auth::guard($guard)->user();

        // // Check if the user is indeed a 'mahasiswa' (by role)
        // if ($user->role !== 'mahasiswa') {
        //     // If the user is not a mahasiswa, redirect them back
        //     return back()->withErrors(['message' => 'You do not have access to this page.']);
        // }

        return view('mahasiswa.dashboard', ['user' => $user]);
    }
}
