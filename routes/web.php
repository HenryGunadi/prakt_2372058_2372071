<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])
        ->name('mahasiswa.dashboard');
});

Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', [KaryawanController::class, 'index'])
        ->name('karyawan.dashboard');
});

// Profile route
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

require __DIR__.'/auth.php';
