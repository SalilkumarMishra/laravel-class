<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // 1. INDEX -> multiple data + header
    public function index()
    {
        $books = Book::all();

        return response()->json($books)
                ->header('X-My-Header', 'Book List Data');
    }

    // 2. SHOW -> single data + cookie
    public function show($id)
    {
        $book = Book::find($id);

        if(!$book){
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json($book)
                ->cookie('book_id', $id, 5); // cookie for 5 minutes
    }
}