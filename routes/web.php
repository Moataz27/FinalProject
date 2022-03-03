<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;



// Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.registerForm')->middleware('guest');
// Route::post('/register', [AuthController::class, 'register'])->name('auth.register')->middleware('guest');
// Route::get('/login', [AuthController::class, 'loginForm'])->name('login')->middleware('guest');
// Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
// Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');


Route::get('/users', [UserController::class , 'index'])->middleware(['auth', 'admin']);