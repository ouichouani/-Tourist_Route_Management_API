<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredishesRequest;
use App\Http\Requests\UpdatedishesRequest;
use App\Models\dishes;

class DishesController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => dishes::all(),
        ]);
    }

    public function store(StoredishesRequest $request)
    {
        $dishes = dishes::create($request->validated());

        return response()->json([
            'data' => $dishes,
            'message' => 'dish created with success'

        ], 201);
    }

    public function show(dishes $dishes)
    {
        return response()->json([
            'data' => $dishes,
        ]);
    }

    public function update(UpdatedishesRequest $request, dishes $dishes)
    {
        $dishes->update($request->validated());

        return response()->json([
            'data' => $dishes->fresh(),
            'message' => 'dish updated with success'

        ]);
    }

    public function destroy(dishes $dishes)
    {
        $dishes->delete();

        return response()->json([
            'message' => 'dish deleted with success'

        ], 200);
    }
}
