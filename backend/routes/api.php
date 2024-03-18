<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

// NTOE: `Route::resouce()` could also be used, but I prefer specifying the routes manually, as it is more descriptive
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::put('/books/{book}', [BookController::class, 'update']);
Route::delete('/books/{book}', [BookController::class, 'destroy']);