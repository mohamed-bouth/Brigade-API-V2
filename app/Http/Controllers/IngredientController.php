<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(){
        $ingredients = Ingredient::all();

        return response()->json([
            'message' => 'this is all Ingredients in platform',
            'ingredients' => $ingredients
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:30|unique:ingredients,name',
            'tags' => 'required'
        ]);

        $ingredient = Ingredient::create([
            'name' => $request->name,
            'tags' => $request->tags
        ]);

        return response()->json([
            'message' => 'Ingredient has created successfully',
            'ingredient' => $ingredient
        ]);
    }

    public function update(Request $request , Ingredient $id){

        $ingredient = $id;

        $request->validate([
            'name' => 'required|min:3|max:30|unique:ingredients,name',
            'tags' => 'required'
        ]);

        $ingredient->update([
            'name' => $request->name,
            'tags' => $request->tags
        ]);

        return response()->json([
            'message' => 'Ingredient has updated successfully',
            'ingredient' => $ingredient
        ]);
    }

    public function destroy(Request $request , Ingredient $id){
        $ingredient = $id;

        $ingredient->delete();

        return response()->json([
            'message' => 'ingredient has seccesfully deleted!',
        ] , 200);
    }

}
