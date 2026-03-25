<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookController;

Route::middleware('book.access')->group(function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);
});
