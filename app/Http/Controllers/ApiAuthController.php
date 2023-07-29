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

        $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ]);

        /*
                           attempt() method
           The attempt method accepts an array of key / value pairs as its first argument.
           The values in the array will be used to find the user in your database table.
           So, the user will be retrieved by the value of the email column.
           If the user is found, the hashed password stored in the database will be compared
           with the password value passed to the method via the array.
           You should not hash the incoming request's password value,
           since the framework will automatically hash the value before comparing it to the hashed password in the database.
           An authenticated session will be started for the user if the two hashed passwords match.
           The attempt method will return true if authentication was successful. Otherwise, false will be returned.

        */

        if (!Auth::attempt($request->only('email', 'password'))) {
            /*

                only mehtod() -->Returns an array containing only the specified input keys from the request.
            */
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
