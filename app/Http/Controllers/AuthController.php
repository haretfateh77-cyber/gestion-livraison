<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'These credentials do not match our records.'
            ], 401);
        }

        return response()->json([
            'user' => Auth::user(),
            'message' => 'Login successful'
        ]);
    }
}