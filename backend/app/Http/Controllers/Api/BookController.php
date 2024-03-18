<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Http\Controllers\Controller;
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
}
