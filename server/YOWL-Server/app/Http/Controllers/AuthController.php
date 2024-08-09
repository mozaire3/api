<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedAttributes =  $request->validate([
            'name' => ['required', 'string', 'regex:/^([A-Za-z0-9\-\_\s]+)$/', 'unique:users'],
            'email' => ['required', 'unique:users', 'regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
            'age' => 'required|numeric',
            'password' => ['required', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        ]);

        //User creation


        $user = User::create($validatedAttributes);

        //create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {

        $validatedAttributes = $request;
        //User creation
        $user = User::where('email', $validatedAttributes['email'])->first();

        if (!$user || !Hash::check($validatedAttributes['password'], $user->password)) {

            return response(
                ['message' => "Bad credentials"],
                401
            );
        }

        //create token
        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json( [ 'user' => $user,
        'token' => $token,
        "status"=>200]);
    }



    public function logout(Request $request)
    {
        // $request->user());
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message'=> "logout"],200);

    }
}
