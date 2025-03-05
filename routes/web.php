<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $role = session('role');

        if ($role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        } elseif ($role === 'karyawan') {
            return redirect()->route('karyawan.dashboard');
        }

        return abort(403, 'Unauthorized access');
    })->name('dashboard');

    Route::get('/mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');

    Route::get('/karyawan/dashboard', function () {
        return view('karyawan.dashboard');
    })->name('karyawan.dashboard');
});

require __DIR__.'/auth.php';
