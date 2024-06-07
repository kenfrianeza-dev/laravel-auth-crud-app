<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetPasswordController;

// Routes for authenticated users
Route::middleware(['authenticated'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::delete('/users/{user}', [AuthController::class, 'destroy'])->name('delete-user');
    Route::patch('/users/{user}', [AuthController::class, 'update'])->name('update-user');
});

// Routes for not authenticated users
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'login']);
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login-user');
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register-user', [AuthController::class, 'registerUser'])->name('register-user');
    Route::get('/forget-password', [ForgetPasswordController::class,'forgetPassword'])->name('forget-password');
    Route::post('/forget-password', [ForgetPasswordController::class,'forgetPasswordPost'])->name('forget-password-post');
    Route::get('/reset-password/{token}', [ForgetPasswordController::class,'resetPassword'])->name('reset-password');
    Route::post('/reset-password', [ForgetPasswordController::class,'resetPasswordPost'])->name('reset-password-post');
});
