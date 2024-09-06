<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\BookService;
use App\Jobs\LogBookCreation;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @OA\Get(
     *     path="/api/books",
     *     summary="Listar todos os livros do usuário autenticado",
     *     tags={"Livros"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de livros retornada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="O Hobbit"),
     *                 @OA\Property(property="author", type="string", example="J.R.R. Tolkien"),
     *                 @OA\Property(property="description", type="string", example="Um clássico da fantasia")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $books = $this->bookService->getAllBooksForUser(Auth::id());
        return response()->json($books, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     summary="Criar um novo livro",
     *     tags={"Livros"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "author"},
     *             @OA\Property(property="title", type="string", example="O Hobbit"),
     *             @OA\Property(property="author", type="string", example="J.R.R. Tolkien"),
     *             @OA\Property(property="description", type="string", example="Um clássico da fantasia")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Livro criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Livro criado com sucesso"),
     *             @OA\Property(property="book", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="O Hobbit"),
     *                 @OA\Property(property="author", type="string", example="J.R.R. Tolkien"),
     *                 @OA\Property(property="description", type="string", example="Um clássico da fantasia")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="O título é obrigatório")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $book = $this->bookService->createBook($request->all(), Auth::id());

        // Despachar o Job após a criação do livro
        LogBookCreation::dispatch($book);

        return response()->json(['message' => 'Livro criado com sucesso', 'book' => $book], 201);
    }

    public function show($id)
    {
        $book = $this->bookService->getBookById($id, Auth::id());

        if (!$book) {
            return response()->json(['error' => 'Livro não encontrado'], 404);
        }

        return response()->json($book, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $updated = $this->bookService->updateBook($id, $request->all(), Auth::id());

        if (!$updated) {
            return response()->json(['error' => 'Livro não encontrado ou não autorizado'], 403);
        }

        return response()->json(['message' => 'Livro atualizado com sucesso'], 200);
    }

    public function destroy($id)
    {
        $deleted = $this->bookService->deleteBook($id, Auth::id());

        if (!$deleted) {
            return response()->json(['error' => 'Livro não encontrado ou não autorizado'], 403);
        }

        return response()->json(['message' => 'Livro deletado com sucesso'], 200);
    }
}