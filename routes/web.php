<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpcrfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('login');
});
Route::get('/registration', function () {
    return view('register');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/encoder', [IpcrfController::class, 'index'])->name('dashboard');
Route::get('/list', [IpcrfController::class, 'list'])->name('ipcrf.list');
Route::get('/upload', [IpcrfController::class, 'create'])->name('upload.create');
Route::post('/upload', [IpcrfController::class, 'store'])->name('upload.store');