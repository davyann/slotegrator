<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);

// Favorites routes
Route::get('favorites', [ProductController::class, 'favorites'])->name('products.favorites');
Route::post('products/{product}/favorite', [ProductController::class, 'toggleFavorite'])->name('products.favorite.toggle');
