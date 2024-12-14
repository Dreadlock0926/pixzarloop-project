<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Borrowing::all()->isEmpty()) {
            return response()->json(['error' => 'No borrowings found'], 404);
        }

        return Borrowing::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'librarian_id' => 'required|exists:users,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

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

        if (!is_numeric($borrow_id)) {
            return response()->json(['error' => 'Invalid borrowing ID'], 400);
        }

        if (!Borrowing::find($borrow_id)) {
            return response()->json(['error' => 'Borrowing not found'], 404);
        }

        // only dates can be updated
        $validator = Validator::make($request->all(), [
            'borrow_date' => 'sometimes|required|date',
            'return_date' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $borrowing = Borrowing::findOrFail($borrow_id);
        $borrowing->update($request->all());

        return response()->json($borrowing);
    }

    public function markReturned($borrow_id)
    {

        if (!is_numeric($borrow_id)) {
            return response()->json(['error' => 'Invalid borrowing ID'], 400);
        }

        if (!Borrowing::find($borrow_id)) {
            return response()->json(['error' => 'Borrowing not found'], 404);
        }

        $borrowing = Borrowing::findOrFail($borrow_id);
        $borrowing->update(['returned' => true]);

        $book = Book::findOrFail($borrowing->book_id);
        $book->borrowed = false;
        $book->save();

        return response()->json(['message' => 'Book returned successfully'], 200);
    }

}
