<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MotorController; 
use App\Http\Controllers\AdminController;

// Rute untuk otentikasi
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('update', [AuthController::class, 'update']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('profile', [AuthController::class, 'profile']);
});

// Rute untuk Motor
Route::apiResource('motors', MotorController::class);

// Rute untuk rekomendasi motor
Route::middleware('auth:sanctum')->get('/motors/recommended', [MotorController::class, 'getRecommendedMotors']);

// Rute untuk admin (misalnya)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Tambahkan rute lainnya di sini
});
