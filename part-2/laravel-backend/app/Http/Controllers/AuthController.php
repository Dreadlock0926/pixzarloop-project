<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // check for user
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('laravel-backend')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);

    }
}
