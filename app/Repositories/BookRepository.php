<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    protected $model;

    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Book $book, array $data)
    {
        return $book->update($data);
    }

    public function delete(Book $book)
    {
        return $book->delete();
    }

}
