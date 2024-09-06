<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;

// Rotas protegidas para CRUD de livros
Route::middleware('auth:api')->group(function () {
    Route::get('books', [BookController::class, 'index']);
    Route::post('books', [BookController::class, 'store']);
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::put('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('books/{id}/favorite', [FavoriteController::class, 'addToFavorites']);
    Route::delete('books/{id}/favorite', [FavoriteController::class, 'removeFromFavorites']);
    Route::get('favorites', [FavoriteController::class, 'listFavorites']);
});
