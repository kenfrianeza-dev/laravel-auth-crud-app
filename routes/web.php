<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Routes for authenticated users
Route::middleware(['authenticated'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout']);
});

// Routes for not authenticated users
Route::middleware(['guest'])->group(function () {
    Route::get("/", [AuthController::class, 'login']);
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login-user');
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register-user', [AuthController::class, 'registerUser'])->name('register-user');
});
