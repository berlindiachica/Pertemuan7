<?php

use App\Http\Controllers\HomeStandardController;
use App\Http\Controllers\HomeAdvanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

// Redirect root ke signup
Route::get('/', function () {
    return redirect('/signup');
});

// Auth Routes
Route::get('/signup', [SignupController::class, 'index'])->name('signup.index');
Route::post('/signup/auth', [SignupController::class, 'signup'])->name('signup.auth');

Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Home Routes untuk kedua tipe user
Route::get('/home-standard', [HomeStandardController::class, 'index'])->name('home.standard');
Route::get('/home-advance', [HomeAdvanceController::class, 'index'])->name('home.advance');
