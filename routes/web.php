<?php

use App\Http\Controllers\HomeStandardController;
use App\Http\Controllers\HomeAdvanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
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

//Pertemuan7
Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');

Route::get('pelanggan',[PelangganController::class, 'index'])->name('pelanggan.list');
Route::get('pelanggan/create',[PelangganController::class, 'create'])->name('pelanggan.create');
Route::post('pelanggan/store',[PelangganController::class, 'store'])->name('pelanggan.store');
