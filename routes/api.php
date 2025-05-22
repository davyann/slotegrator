<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductFavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', fn(Request $request) => $request->user());
});


Route::prefix('v1')->group(function () {
    Route::prefix('products')->group(function () {
        Route::prefix('favorites')->group(function () {
            Route::post('/', [ProductFavoriteController::class, 'store']);
            Route::get('/', [ProductFavoriteController::class, 'index']);

        })->middleware('auth:sanctum');
    });

    Route::get('/products', [ProductController::class, 'index']);
});
