<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken('access_token');

            return response()->json(['access_token' => $token->plainTextToken]);
        }
        return response()->json(['message' => 'Invalid email or password',], 422);
    }

    public function logout()
    {
        $this->user->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
