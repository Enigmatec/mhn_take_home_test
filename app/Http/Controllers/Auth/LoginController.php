<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false, 
                'message' => 'Login failed. Invalid email or password.',
            ], 401);
        }

        $token = $request->user()->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => true, 
            'message' => 'Login successful.',
            'user' => auth()->user(),
            'token' => $token
        ], 200);
    }
}
