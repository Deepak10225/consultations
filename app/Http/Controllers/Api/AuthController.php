<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered'], 201);
    }

    public function login(Request $request)
    {
       
        // if ($validator->fails()) return response()->json($validator->errors(), 422);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login'], 401);
        }

        $token = Auth::user()->createToken('LaravelApp')->accessToken;

        return response()->json(['token' => $token]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out']);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->update($request->only(['name', 'email']));
        return response()->json(['message' => 'Profile updated']);
    }
}
