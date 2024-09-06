<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\BookService;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    // Listar todos os livros do usuário autenticado
    public function index()
    {
        $books = $this->bookService->getAllBooksForUser(Auth::id());
        return response()->json($books, 200);
    }

    // Criar um novo livro
    public function store(Request $request)
    {
        // Validações
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',  // Limite opcional de tamanho
        ]);

        // Criação do livro
        $book = $this->bookService->createBook($request->all(), Auth::id());

        return response()->json(['message' => 'Livro criado com sucesso', 'book' => $book], 201);
    }

    // Mostrar um livro específico
    public function show($id)
    {
        $book = $this->bookService->getBookById($id, Auth::id());

        if (!$book) {
            return response()->json(['error' => 'Livro não encontrado'], 404);
        }

        return response()->json($book, 200);
    }

    // Atualizar um livro existente
    public function update(Request $request, $id)
    {
        // Validações
        $this->validate($request, [
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Atualização do livro
        $updated = $this->bookService->updateBook($id, $request->all(), Auth::id());

        if (!$updated) {
            return response()->json(['error' => 'Livro não encontrado ou não autorizado'], 403);
        }

        return response()->json(['message' => 'Livro atualizado com sucesso'], 200);
    }

    // Deletar um livro
    public function destroy($id)
    {
        $deleted = $this->bookService->deleteBook($id, Auth::id());

        if (!$deleted) {
            return response()->json(['error' => 'Livro não encontrado ou não autorizado'], 403);
        }

        return response()->json(['message' => 'Livro deletado com sucesso'], 200);
    }
}
