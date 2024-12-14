<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Member::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'contact_number' => 'required|string|max:20',
        ]);

        $member = Member::create($request->all());

        return response()->json($member, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Member::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'contact_number' => 'sometimes|required|string|max:20',
        ]);

        $member->update($validatedData);

        return response()->json(['message' => 'Member updated successfully', 'member' => $member]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json(['message' => 'Member deleted successfully'], 200);
    }
}
