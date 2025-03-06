<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// General dashboard (redirects based on role)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Role-based dashboards
Route::get('/mahasiswa/dashboard', [DashboardController::class, 'index'])
    ->name('mahasiswa.dashboard');

Route::get('/karyawan/dashboard', [DashboardController::class, 'index'])
    ->name('karyawan.dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');


require __DIR__.'/auth.php';
