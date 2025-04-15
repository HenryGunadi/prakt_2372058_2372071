<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Mahasiswa\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
use Illuminate\Support\Facades\Route;


Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::middleware('guest:mahasiswa')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        
    });

    // Auth Routes
    Route::middleware('auth:mahasiswa')->group(function () {
        Route::get("/dashboard", [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/surat', [SuratController::class, 'index'])->name('surat');
        Route::post('/surat', [SuratController::class, 'store'])->name('surat.post');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');
        Route::get('/download/surat/{filename}', [SuratController::class, 'download'])->name('surat.download');


        // Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        //     ->name('logout');
    });
});
