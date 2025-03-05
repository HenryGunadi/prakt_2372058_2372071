<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = session('role');

        if ($role === 'mahasiswa') {
            return view('mahasiswa.dashboard');
        } elseif ($role === 'karyawan') {
            return view('karyawan.dashboard', ['karyawan_role' => session('karyawan_role')]);
        }

        return abort(403, 'Unauthorized.');
    }
}
