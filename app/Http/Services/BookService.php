<?php

namespace App\Http\Services;

use App\Repositories\BookRepository;
use App\Models\Book;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function getAllBooksForUser(int $userId)
    {
        return Book::where('user_id', $userId)->get();
    }

    public function createBook(array $data, int $userId)
    {
        $data['user_id'] = $userId;
        return $this->bookRepository->create($data);
    }

    public function updateBook(int $id, array $data, int $userId)
    {
        $book = $this->bookRepository->findById($id);

        if ($book && $book->user_id === $userId) {
            return $this->bookRepository->update($book, $data);
        }

        return false;
    }

    public function deleteBook(int $id, int $userId)
    {
        $book = $this->bookRepository->findById($id);

        if ($book && $book->user_id === $userId) {
            return $this->bookRepository->delete($book);
        }

        return false;
    }
}