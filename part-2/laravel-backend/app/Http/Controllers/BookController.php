<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Get all books
    public function index()
    {
        return response()->json(Book::with(['author', 'genre'])->get());
    }

    // Get a specific book
    public function show($id)
    {
        return response()->json(Book::with(['author', 'genre'])->findOrFail($id));
    }

    // Create a new book
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:200',
            'isbn' => 'required|string|size:13',
            'author_id' => 'required|exists:authors,author_id',
            'genre_id' => 'required|exists:genres,genre_id',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    // Update an existing book
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'description' => 'sometimes|required|string|max:200',
            'isbn' => 'sometimes|required|string|size:13',
            'author_id' => 'sometimes|required|exists:authors,author_id',
            'genre_id' => 'sometimes|required|exists:genres,genre_id',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json($book);
    }

    // Delete a book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}