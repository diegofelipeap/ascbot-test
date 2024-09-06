<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;

// Rotas de autenticação
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// Rotas protegidas para CRUD de livros
Route::middleware('auth:api')->group(function () {
    Route::get('books', [BookController::class, 'index']);
    Route::post('books', [BookController::class, 'store']);
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::put('books/{id}', [BookController::class, 'update']);
    Route::delete('books/{id}', [BookController::class, 'destroy']);
});

// Rotas protegidas para favoritos
Route::middleware('auth:api')->group(function () {
    Route::post('books/{id}/favorite', [FavoriteController::class, 'addToFavorites']);
    Route::delete('books/{id}/favorite', [FavoriteController::class, 'removeFromFavorites']);
    Route::get('favorites', [FavoriteController::class, 'listFavorites']);
});
