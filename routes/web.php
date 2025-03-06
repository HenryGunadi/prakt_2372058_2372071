<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;

// Home route
Route::get('/', function () {
    return view('welcome'); // or your custom view
})->name('home');  // You can name it 'home' or any name you prefer
// Role-based dashboards
Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])
    ->middleware('auth:mahasiswa')
    ->name('mahasiswa.dashboard');

Route::get('/karyawan/dashboard', [KaryawanController::class, 'index'])
    ->middleware('auth:karyawan')
    ->name('karyawan.dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');


require __DIR__.'/auth.php';
