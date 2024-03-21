<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query()->select(['id', 'author', 'title', 'isbn', 'publish_date', 'on_store', 'summary']);
        if ($request->has('q')) {
            $query->where('title', 'like', '%'.$request->input('q').'%');
        }

        return BookResource::collection($query->orderBy('title', 'desc')->paginate(20));
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return response()->json([
            'data' => [
                'success' => true,
                'id' => $book->id,
            ],
        ], 201);
    }

    public function update(StoreBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return response()->json([
            'data' => [
                'success' => true,
                'id' => $book->id,
            ],
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'data' => [
                'success' => true,
            ],
        ]);
    }
}
