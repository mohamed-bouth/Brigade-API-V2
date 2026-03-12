<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mime\Email;
use App\Docs\AuthDocumentation;

class AuthController extends Controller implements AuthDocumentation
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required|min:3|max:64',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|max:64'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'user has seccesfuly created',
            'user' => $user,
            'token' => $token
        ] , 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = User::where('email' , $request->email)->first();
        if(!$user || !Hash::check($request->password , $user->password)){
            return response()->json([
                'message' => 'check your information and try again!'
            ] , 401);

        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'user has seccesfuly login',
            'token' => $token
        ] , 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'the user has seccesfuly logout'
        ] , 200);
    }
}
