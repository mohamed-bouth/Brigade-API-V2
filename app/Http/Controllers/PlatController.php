<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plats = Plat::where('user_id' , $request->user()->id)->get();

        return response()->json([
            'message' => 'this is all the user plats',
            'plats' => $plats
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:64',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        $plat = Plat::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'message' => 'plat has seccesfully created!',
            'plat' => $plat
        ] , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plat $id)
    {
        return response()->json([
            'message' => 'this is your plat',
            'plat' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plat $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plat $id)
    {   
        Gate::authorize('update' , $id);

        $request->validate([
            'name' => 'required|min:3|max:64',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        $id->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json([
            'message' => 'plat has seccesfully updated!',
            'plat' => $id
        ] , 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plat $id)
    {   
        Gate::authorize('delete' , $id);
        $id->delete();

        return response()->json([
            'message' => 'plat has seccesfully deleted!',
        ] , 200);
    }
}
