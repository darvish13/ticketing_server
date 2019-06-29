<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        $userData = request(['name', 'email', 'password', 'role']);
        $userData['password'] = Hash::make($userData['password']);
        $user = User::create($userData);

        $token = auth()->login($user);

        return response()->json(['token' => $token, 'user' => auth()->user()]);
    }


    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized', 'credentials' => $credentials], 401);
        }

        return response()->json(['token' => $token, 'user' => auth()->user()]);
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
