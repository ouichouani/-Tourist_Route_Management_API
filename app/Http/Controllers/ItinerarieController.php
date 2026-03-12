<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreitinerarieRequest;
use App\Http\Requests\UpdateitinerarieRequest;
use App\Models\itinerarie;
use Illuminate\Http\Request;

class ItinerarieController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => itinerarie::all(),
        ]);
    }

    public function filter(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'duration_from' => ['nullable', 'date'],
            'duration_to' => ['nullable', 'date', 'after_or_equal:duration_from'],
        ]);

        $query = itinerarie::query();

        if (!empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        if (!empty($validated['duration_from'])) {
            $query->where('duration_from', '>=', $validated['duration_from']);
        }

        if (!empty($validated['duration_to'])) {
            $query->where('duration_to', '<=', $validated['duration_to']);
        }

        return response()->json([
            'data' => $query->get(),
        ]);
    }

    public function store(StoreitinerarieRequest $request)
    {
        $itinerarie = itinerarie::create($request->safe()->except('destinations'));
        $itinerarie->destinations()->attach($request->destinations) ;


        return response()->json([
            'data' => $itinerarie->load('destinations'),
            'message' => 'itinerarie created with success'

        ], 201);
    }

    public function show(itinerarie $itinerarie)
    {
        return response()->json([
            'data' => $itinerarie,
        ]);
    }

    public function update(UpdateitinerarieRequest $request, itinerarie $itinerarie)
    {
        $itinerarie->update($request->validated());

        return response()->json([
            'data' => $itinerarie->fresh(),
            'message' => 'itinerarie updated with success'

        ]);
    }

    public function destroy(itinerarie $itinerarie)
    {
        $itinerarie->delete();

        return response()->json([
            'message' => 'itinerarie deleted with success'
        ], 200);
    }
}







