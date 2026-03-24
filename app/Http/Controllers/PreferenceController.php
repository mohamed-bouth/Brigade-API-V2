<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;

class PreferenceController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        $preference = Preference::where('user_id' , $user->id)->get();

        return response()->json([
            'message' => 'this is all your preferences',
            'preferences' => $preference
        ]);
        
    }

    public function store(Request $request){

        $user = $request->user();

        $request->validate([
            'ingredient' => 'required|max:30',
            'type' => 'required'
        ]);

        $preference = Preference::create([
            'ingredient' => $request->ingredient,
            'type' => $request->type,
            'user_id' => $user->id
            ]);

        return response()->json(['message' => 'the Preference created successfully',
                                 'user' => $user,
                                 'Preference' => $preference]);         
    }

    public function update(Request $request , Preference $id){

        $user = $request->user();

        $request->validate([
            'ingredient' => 'required|max:30',
            'type' => 'required'
        ]);

        $preference = $id->update([
            'ingredient' => $request->ingredient,
            'type' => $request->type
            ]);

        return response()->json(['message' => 'the Preference updated successfully',
                                 'user' => $user,
                                 'Preference' => $preference]);         
    }
}
