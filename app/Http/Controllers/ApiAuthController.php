<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request)

    {

        // return $request;
        $request->validate([
            "name" => "required|min:3",
            "email" => "required|email|unique:users",
            "password" => "required|min:8|confirmed"
        ]);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        return response()->json([
            "message" => "User register successful",
        ]);
    }

    public function login(Request $request)
    {
        // return $request;
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                "message" => "Username or password wrong",
            ]);
        }

        return Auth::user()->createToken("samsaung");
    }


    public function logout()

    {
        // return Auth::user()->currentAccessToken();
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "logout successful"
        ]);
    }

    public function logoutAll()
    {
        // return Auth::user()->tokens;
        foreach (Auth::user()->tokens as $token) {
            $token->delete();
        }

        return response()->json([
            "message" => "logoutAll successful"
        ]);
    }
}
