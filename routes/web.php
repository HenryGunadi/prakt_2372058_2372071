<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaprodiController;
use App\Models\Surat;

Route::get('/', function () {
    return view('welcome');
});

// // Mahasiswa Dashboard
// Route::middleware('redirectIfNotAuthenticated:mahasiswa')->group(function () {
//     Route::get('/mahasiswa/dashboard', function () {
//         return view('mahasiswa.dashboard');
//     })->name('mahasiswa.dashboard');
// });

// // Karyawan Dashboard
// Route::middleware('redirectIfNotAuthenticated:karyawan')->group(function () {
//     Route::get('/karyawan/dashboard', function () {
//         return view('karyawan.dashboard');
//     })->name('karyawan.dashboard');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Kaprodi Dashboard
Route::middleware(['auth', 'kaprodi'])->group(function () {
    Route::get('/kaprodi/dashboard', [KaprodiController::class, 'index'])->name('kaprodi.dashboard');
});


require __DIR__.'/auth.php';
require __DIR__.'/karyawan.php';
require __DIR__.'/mahasiswa.php';
