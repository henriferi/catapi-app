<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatController;


Route::get('/breeds', [CatController::class, 'getBreeds']);
Route::get('/search', [CatController::class, 'search'])->name('cats.search');
Route::get('/', [CatController::class, 'index'])->name('cats.index');
