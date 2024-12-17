<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterNewUserRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterNewUserRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('access_token');
        return response()->json(['access_token' => $token->plainTextToken], 201);
    }
}
