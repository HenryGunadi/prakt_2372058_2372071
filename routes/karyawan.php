<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Karyawan\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Karyawan\ProfileController;
use Illuminate\Support\Facades\Route;


Route::prefix('karyawan')->name('karyawan.')->group(function () {

    Route::middleware('guest:karyawan')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    // Auth Routes
    Route::middleware('auth:karyawan')->group(function () {
        Route::get('/dashboard', function () {
            return view('karyawan.dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
});
