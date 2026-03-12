<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreplacesRequest;
use App\Http\Requests\UpdateplacesRequest;
use App\Models\places;

class PlacesController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => places::all(),
        ]);
    }

    public function store(StoreplacesRequest $request)
    {
        $places = places::create($request->validated());

        return response()->json([
            'data' => $places,
            'message' => 'place created with success'

        ], 201);
    }

    public function show(places $places)
    {
        return response()->json([
            'data' => $places,
        ]);
    }

    public function update(UpdateplacesRequest $request, places $places)
    {
        $places->update($request->validated());

        return response()->json([
            'data' => $places->fresh(),
            'message' => 'place updated with success'

        ]);
    }

    public function destroy(places $places)
    {
        $places->delete();

        return response()->json([
            'message' => 'place deleted with success'
        ], 200);
    }
}
