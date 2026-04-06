<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UserController extends Controller
{
    
    public function users(Request $request){
        $user = User::whereBetween('id', [$request->first, $request->last])->get();

        return response()->json([
            'user' => $user
        ]);
    }

    public function show(Request $request){
        $user = $request->user();

        return response()->json([
            'profile' => $user
        ]);
    }

    public function test(){
        return response()->json(['message' => 'the test work successefuly']);
    }
}