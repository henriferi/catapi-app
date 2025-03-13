<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ProfileController;


Route::get('/breeds', [CatController::class, 'getBreeds']);
Route::get('/search', [CatController::class, 'search'])->name('cats.search');
Route::get('/', [CatController::class, 'index'])->name('cats.index');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/profile', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('profile');


Route::middleware(['auth'])->group(function () {
    Route::post('/favoritar/{gato_id}', [FavoritoController::class, 'favoritar'])->name('favoritar');
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos');
});

Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');


Route::get('/load-more-cats', [CatController::class, 'loadMoreCats'])->name('cats.loadMore');
