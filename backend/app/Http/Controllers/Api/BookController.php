<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query()->select(['id', 'author', 'title', 'isbn', 'publish_date', 'on_store']);
        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->input('q') . '%');
        }
        
        return BookResource::collection($query->get());
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());
        return response()->json([
            'links' => [
                'self' => route('books.show', ['book' => $book->id])
            ],
        ], 201);
    }

    public function update(StoreBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return response()->json([
            'links' => [
                'self' => route('books.show', ['book' => $book->id])
            ],
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'links' => [
                'list' => route('books.index'),
            ] 
        ]);
    }
}
