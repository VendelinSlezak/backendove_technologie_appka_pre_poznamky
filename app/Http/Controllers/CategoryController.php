<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('updated_at')->get();

        return response()->json(['categories' => $categories], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:64', 'unique:categories'],
            'color' => ['required', 'string', 'max:16'],
        ]);

        $category = Category::create([
            'name' => $validated['name'],
            'color' => $validated['color'],
        ]);

        return response()->json([
            'message' => 'Kategória bola úspešne vytvorená.',
            'category' => $category,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(['category' => $category], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:64', 'unique:categories'],
            'color' => ['required', 'string', 'max:16'],
        ]);

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategória nenájdená.'], Response::HTTP_NOT_FOUND);
        }

        $category->update([
            'name' => $validated['name'],
            'color' => $validated['color'],
        ]);

        return response()->json(['message' => 'Kategória bola úspešne aktualizovaná.'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Kategória bola úspešne odstránená.'], Response::HTTP_OK);
    }
}
