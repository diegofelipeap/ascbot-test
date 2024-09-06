<?php

namespace App\Http\Services;

use App\Models\Book;

class BookService
{
    public function getAllBooksForUser($userId)
    {
        return Book::where('user_id', $userId)->get();
    }

    public function createBook(array $data, $userId)
    {
        $data['user_id'] = $userId;
        return Book::create($data);
    }

    public function getBookById($id, $userId)
    {
        return Book::where('id', $id)->where('user_id', $userId)->first();
    }

    public function updateBook($id, array $data, $userId)
    {
        $book = $this->getBookById($id, $userId);

        if (!$book) {
            return false;
        }

        return $book->update($data);
    }

    public function deleteBook($id, $userId)
    {
        $book = $this->getBookById($id, $userId);

        if (!$book) {
            return false;
        }

        return $book->delete();
    }
}