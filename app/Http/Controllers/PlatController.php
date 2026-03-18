<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Docs\PlatDocumentation;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class PlatController extends Controller implements PlatDocumentation
{

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
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('plats', 'r2');
            $imageUrl = env('CLOUDFLARE_PUBLIC_URL') . '/' . $path;
        }

        $plat = Plat::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imageUrl,
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
        $plat = $id;
        Gate::authorize('update' , $plat);

        $request->validate([
            'name' => 'required|min:3|max:64',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric',
            'is_available' => 'required|numeric'
        ]);

        if ($request->hasFile('image')) {
        
            if ($plat->image) {
                $publicUrl = rtrim(env('CLOUDFLARE_PUBLIC_URL'), '/');
                $oldPath = str_replace($publicUrl . '/', '', $plat->image);
                
                Storage::disk('r2')->delete($oldPath);
            }
            $newPath = $request->file('image')->store('plats', 'r2');
            $plat->image = rtrim(env('CLOUDFLARE_PUBLIC_URL'), '/') . '/' . $newPath;
        }

        $id->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $plat->image,
            'is_available' => $request->is_available
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
        $plat = $id;
        Gate::authorize('delete' , $plat);

        if($plat->image){
            $publicUrl = rtrim(env('CLOUDFLARE_PUBLIC_URL'), '/');
            $oldPath = str_replace($publicUrl . '/', '', $plat->image);
            Storage::disk('r2')->delete($oldPath);
        }

        $id->delete();

        return response()->json([
            'message' => 'plat has seccesfully deleted!',
        ] , 200);
    }
}
