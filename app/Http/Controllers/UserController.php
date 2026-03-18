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

    public function store(Request $request){

        $user = $request->user();

        $user->update(['dietary_tags' => $request->dietary_tags]);

        return response()->json(['message' => 'the dietaries updated successfully',
                                 'user' => $user]);         
    }
}