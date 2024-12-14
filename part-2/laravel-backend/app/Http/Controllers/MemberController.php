<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Member::all()->isEmpty()) {
            return response()->json(['error' => 'No members found'], 404);
        }

        return Member::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'contact_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $member = Member::create($request->all());

        return response()->json($member, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid member ID'], 400);
        }

        $member = Member::find($id);

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        return response()->json($member, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:50',
            'contact_number' => 'sometimes|required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if (!$request->has('name') && !$request->has('contact_number')) {
            return response()->json(['error' => 'Either name or contact number are required'], 400);
        }

        $member->update($request->all());

        return response()->json(['message' => 'Member updated successfully', 'member' => $member]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid member ID'], 400);
        }

        $member = Member::findOrFail($id);

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        $member->delete();
        return response()->json(['message' => 'Member deleted successfully'], 200);
    }
}
