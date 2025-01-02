<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MotorController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\ForgotPasswordApiController;


// Rute untuk otentikasi
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('update', [AuthController::class, 'update']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('/checkouts', [CheckoutController::class, 'getRiwayat']);
    Route::post('/checkout', [CheckoutController::class, 'store']);
});

// Rute untuk Motor
Route::apiResource('motors', MotorController::class);

// Rute untuk rekomendasi motor
Route::get('/motor/recommended', [MotorController::class, 'getRecommendedMotors']);


Route::middleware('auth:sanctum')->post('/checkout/upload-bukti/{id}', [CheckoutController::class, 'uploadBuktiTransaksi']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/carts', [CartController::class, 'index']);
    Route::post('/carts', [CartController::class, 'store']);
    Route::delete('/carts/{id}', [CartController::class, 'destroy']);
});

// Rute lupa password
// Kirim OTP
Route::post('forgot-password/send-otp', [ForgotPasswordApiController::class, 'sendOtp']);
// Verifikasi OTP
Route::post('forgot-password/verify-otp', [ForgotPasswordApiController::class, 'verifyOtp']);
// Reset Password
Route::post('forgot-password/reset-password', [ForgotPasswordApiController::class, 'resetPassword']);

// // Rute untuk admin (misalnya)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
//     // Tambahkan rute lainnya di sini
// });




