<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;
use App\Http\Controllers\AuthController;

Route::get('/breeds', [CatController::class, 'getBreeds']);
Route::get('/search', [CatController::class, 'search'])->name('cats.search');
Route::get('/', [CatController::class, 'index'])->name('cats.index');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', function () {
    return view('profile.profile');
})->middleware('auth')->name('profile');
