<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'phone' => 'required|string|unique:users', // Validasi nomor telepon
        ]);

        $user = new User([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone, // Menyimpan nomor telepon
            'is_admin' => 0, // Atur is_admin ke 0 untuk pengguna biasa
        ]);

        $user->save();

        return response()->json([
            'message' => 'User successfully registered'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = request(['username', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function profile()
    {
        $user = auth('sanctum')->user();

        return response()->json($user);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth('sanctum')->user()->id);

        $request->validate([
            'username' => 'string|unique:users,username,' . $user->id,
            'password' => 'string',
        ]);

        if ($request->has('username')) {
            $user->username = $request->username;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number; // Update nomor telepon
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully'
        ], 200);
    }
}
