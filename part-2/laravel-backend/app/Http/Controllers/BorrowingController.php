<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Borrowing::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'book_id' => 'required|exists:books,book_id',
            'member_id' => 'required|exists:members,member_id',
            'librarian_id' => 'required|exists:users,user_id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date',
        ]);

        $borrowing = Borrowing::create([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'librarian_id' => $request->librarian_id,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'returned' => false,
        ]);

        $book = Book::findOrFail($request->book_id);
        $book->borrowed = true;
        $book->save();

        return response()->json($borrowing, 201);

    }

    public function update(Request $request, $borrow_id) 
    {
        // only dates can be updated
        $request -> validate([
            'borrow_date' => 'sometimes|required|date',
            'return_date' => 'sometimes|required|date',
        ]);

        $borrowing = Borrowing::findOrFail($borrow_id);
        $borrowing->update($request->all());

        return response()->json($borrowing);
    }

    public function markReturned($borrow_id)
    {
        $borrowing = Borrowing::findOrFail($borrow_id);
        $borrowing->update(['returned' => true]);

        $book = Book::findOrFail($borrowing->book_id);
        $book->borrowed = false;
        $book->save();

        return response()->json(['message' => 'Book returned successfully'], 200);
    }

}
