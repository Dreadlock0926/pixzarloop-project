<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // Get all books
    public function index()
    {
        if (Book::all()->isEmpty()) {
            return response()->json(['error' => 'No books found'], 404);
        }

        return response()->json(Book::with(['author', 'genre'])->get());
    }

    // Get a specific book
    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid book ID'], 400);
        }

        if (!Book::find($id)) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json(Book::with(['author', 'genre'])->findOrFail($id));
    }

    // Create a new book
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'description' => 'sometimes|required|string|max:200',
            'isbn' => 'required|string|size:13',
            'author_id' => 'required|exists:authors,author_id',
            'genre_id' => 'sometimes|required|exists:genres,genre_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    // Update an existing book
    public function update(Request $request, $id)
    {

        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid book ID'], 400);
        }

        if (!Book::find($id)) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:50',
            'description' => 'sometimes|required|string|max:200',
            'isbn' => 'sometimes|required|string|size:13',
            'author_id' => 'sometimes|required|exists:authors,author_id',
            'genre_id' => 'sometimes|required|exists:genres,genre_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json($book);
    }

    // Delete a book
    public function destroy($id)
    {

        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid book ID'], 400);
        }

        if (!Book::find($id)) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $book = Book::findOrFail($id);
        $book->delete();
    
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}