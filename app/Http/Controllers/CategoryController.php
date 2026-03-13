<?php

namespace App\Http\Controllers;

use App\Docs\CategoryDocumentation;
use App\Models\Category;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller implements CategoryDocumentation
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::where('user_id' , $request->user()->id)->get();

        return response()->json([
            'message' => 'this is all the user categories',
            'plats' => $categories
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('plats_images', 'r2');
            $imageUrl = env('CLOUDFLARE_PUBLIC_URL') . '/' . $path;
        }

        $category = Category::create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
            'image' => $imageUrl
        ]);

        return response()->json([
            'message' => 'category has seccesfully created!',
            'plat' => $category
        ] , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $id)
    {
        return response()->json([
            'message' => 'this is your Category',
            'plat' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , Category $id)
    {
        $category = $id;
        Gate::authorize('update' , $category);

        $request->validate([
            'name' => 'required|min:3|max:64',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
        
            if ($category->image) {
                $publicUrl = rtrim(env('CLOUDFLARE_PUBLIC_URL'), '/');
                $oldPath = str_replace($publicUrl . '/', '', $category->image);
                
                Storage::disk('r2')->delete($oldPath);
            }
            $newPath = $request->file('image')->store('categories', 'r2');
            $category->image = rtrim(env('CLOUDFLARE_PUBLIC_URL'), '/') . '/' . $newPath;
        }

        $id->update([
            'name' => $request->name,
            'image' => $category->image
        ]);

        return response()->json([
            'message' => 'category has seccesfully updated!',
            'category' => $id
        ] , 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $id)
    {
        $category = $id;
        Gate::authorize('delete' , $category);

        if($category->image){
            $publicUrl = rtrim(env('CLOUDFLARE_PUBLIC_URL'), '/');
            $oldPath = str_replace($publicUrl . '/', '', $category->image);
            Storage::disk('r2')->delete($oldPath);
        }

        $id->delete();

        return response()->json([
            'message' => 'Category has seccesfully deleted!',
        ] , 200);
    }

    public function add(Request $request , $id)
    {
        $request->validate([
            'plat_id' => 'required|exists:plats,id'
        ]);
        $plat = Plat::findOrFail($request->plat_id);
        $category = Category::findOrFail($id);

        Gate::authorize('update', $plat);
        Gate::authorize('update', $category);

        $plat->update([
            'category_id' => $id
        ]);

        return response()->json([
            'message' => 'the plat has seccsefully added to category',
            'plat' => $plat,
            'category_id' => $id
        ]);
    }
}
