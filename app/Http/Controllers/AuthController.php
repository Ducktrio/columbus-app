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
            return redirect()->route('index')->with('success', 'You are logged in');
        }
        return redirect()->route('login')->with("error", "Invalid credentials");
    }

    public function get()
    {
        return Auth::user();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index')->with('info', "You have logged out from the system");
    }
}
