<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;
use App\Models\category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => category::all(),
        ]);
    }

    public function store(StorecategoryRequest $request)
    {
        $category = category::create($request->validated());

        return response()->json([
            'data' => $category,
            'message' => 'cat created with success'
        ], 201);
    }

    public function show(category $category)
    {
        return response()->json([
            'data' => $category,
        ]);
    }

    public function update(UpdatecategoryRequest $request, category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'data' => $category->fresh(),
            'message' => 'cat updated with success'
        ]);
    }

    public function destroy(category $category)
    {
        
        $category->delete();
        return response()->json(['message' => 'cat destroyed with success'], 200);
    }
}
