<?php

use App\Http\Controllers\Mahasiswa\Auth\AuthenticatedSessionController as MahasiswaAuth;
use App\Http\Controllers\Karyawan\Auth\AuthenticatedSessionController as KaryawanAuth;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Public routes for guests (No authentication required)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Password Reset
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Mahasiswa authenticated routes (Only for mahasiswa users)
Route::middleware('auth:mahasiswa')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('mahasiswa.verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('mahasiswa.verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('mahasiswa.verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('mahasiswa.password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('mahasiswa.password.update');
    Route::post('logout/mahasiswa', [MahasiswaAuth::class, 'destroy'])->name('mahasiswa.logout');
});

// Karyawan authenticated routes (Only for karyawan users)
Route::middleware('auth:karyawan')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('karyawan.verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('karyawan.verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('karyawan.verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('karyawan.password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('karyawan.password.update');
    Route::post('logout/karyawan', [KaryawanAuth::class, 'destroy'])->name('karyawan.logout');
});
