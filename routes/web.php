<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Api\CheckoutController;


// Route untuk dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Rute untuk autentikasi admin
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post'); 
Route::get('admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('admin/register', [AdminAuthController::class, 'register'])->name('admin.register.post'); 
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Middleware untuk memastikan admin telah login sebelum mengakses halaman dashboard dan lainnya
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Routes untuk motor
    Route::get('/admin/motor', [AdminController::class, 'manageMotor'])->name('admin.motor');
    Route::get('/admin/motor/create', [AdminController::class, 'createMotor'])->name('admin.motor.create');
    Route::post('/admin/motor', [AdminController::class, 'storeMotor'])->name('admin.motor.store');
    Route::get('/admin/motor/edit/{id}', [AdminController::class, 'editMotor'])->name('admin.motor.edit');
    Route::put('/admin/motor/{id}', [AdminController::class, 'updateMotor'])->name('admin.motor.update');
    Route::delete('/admin/motor/{id}', [AdminController::class, 'destroyMotor'])->name('admin.motor.destroy');
    
    // Routes untuk manajemen pengguna
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users'); // <-- Route ini ditambahkan
    Route::get('admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('admin/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('admin/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
});

// routes/web.php
Route::get('/admin/checkouts', [CheckoutController::class, 'showCheckouts'])->name('admin.checkouts');

// Redirect ke halaman login admin jika pengguna mencoba mengakses route 'login' utama
Route::get('login', function() {
    return redirect()->route('admin.login');
})->name('login');



// Rute default untuk halaman utama
Route::get('dashboard', function () {
    return view('welcome');
});

