<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class FavoriteController extends Controller
{
    // Adicionar livro aos favoritos
    public function addToFavorites($bookId)
    {
        $user = Auth::user();
        $book = Book::find($bookId);

        if (!$book) {
            return response()->json(['error' => 'Livro não encontrado'], 404);
        }

        // Verifica se já foi favoritado
        if ($user->favoriteBooks()->where('book_id', $bookId)->exists()) {
            return response()->json(['message' => 'Livro já está nos favoritos'], 200);
        }

        $user->favoriteBooks()->attach($bookId);

        return response()->json(['message' => 'Livro adicionado aos favoritos'], 200);
    }

    // Remover livro dos favoritos
    public function removeFromFavorites($bookId)
    {
        $user = Auth::user();
        $book = Book::find($bookId);

        if (!$book) {
            return response()->json(['error' => 'Livro não encontrado'], 404);
        }

        if (!$user->favoriteBooks()->where('book_id', $bookId)->exists()) {
            return response()->json(['message' => 'Livro não está nos favoritos'], 404);
        }

        $user->favoriteBooks()->detach($bookId);

        return response()->json(['message' => 'Livro removido dos favoritos'], 200);
    }

    // Listar livros favoritos do usuário
    public function listFavorites()
    {
        $user = Auth::user();
        $favoriteBooks = $user->favoriteBooks()->get();

        return response()->json($favoriteBooks, 200);
    }
}