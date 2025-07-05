<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    public function register(CreateUserRequest $createUserRequest)
    {
        $data = $createUserRequest->validated();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(LoginRequest $loginRequest)
    {
        $credentials = Arr::only($loginRequest->validated(), ['username', 'password']);
        if (Auth::attempt($credentials)) {
            $loginRequest->session()->regenerate();
            return response()->json(['message' => 'Login successful'], 200);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logout successful'], 200);
    }
}
