<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $userData = request(['name', 'email', 'password', 'role']);
        $existingUser = User::where('email', '=', $request->get('email'))->get();

        if (sizeof($existingUser) == 0) {
            $userData['password'] = Hash::make($userData['password']);
            $user = User::create($userData);
            $token = auth()->login($user);

            return response()->json(['token' => $token, 'user' => auth()->user()]);
        } else {
            return response()->json(['error' => 'این نام کاربری قبلا ثبت شده است'], 401);
        }
    }


    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token, 'user' => auth()->user()]);
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}