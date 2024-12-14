<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Genre::all()->isEmpty()) {
            return response()->json(['error' => 'No genres found'], 404);
        }

        return response()->json(Genre::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $genre = Genre::create($request->all());

        return response()->json($genre, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid genre ID'], 400);
        }

        if (!Genre::find($id)) {
            return response()->json(['error' => 'Genre not found'], 404);
        }

        return response()->json(Genre::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if (!Genre::find($id)) {
            return response()->json(['error' => 'Genre not found'], 404);
        }

        $genre = Genre::findOrFail($id);
        $genre->update($request->all());

        return response()->json($genre);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid genre ID'], 400);
        }

        if (!Genre::find($id)) {
            return response()->json(['error' => 'Genre not found'], 404);
        }

        $genre = Genre::findOrFail($id);
        $genre->delete();

        return response()->json(['message' => 'Genre deleted successfully'], 200);
    }
}
