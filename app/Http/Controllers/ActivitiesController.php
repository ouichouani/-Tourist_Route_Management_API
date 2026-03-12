<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreactivitiesRequest;
use App\Http\Requests\UpdateactivitiesRequest;
use App\Models\activities;

class ActivitiesController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => activities::all(),
        ], 200);
    }

    public function store(StoreactivitiesRequest $request)
    {
        $activities = activities::create($request->validated());

        return response()->json([
            'data' => $activities,
            'message' => 'activity created with success'

        ], 201);
    }

    public function show(activities $activity)
    {
        return response()->json([
            'data' => $activity,
        ], 200);
    }

    public function update(UpdateactivitiesRequest $request, activities $activity)
    {
        $activity->update($request->validated());
        return response()->json([
            'data' => $activity->fresh(),
            'message' => 'activity updated with success'

        ]);
    }

    public function destroy(activities $activity)
    {
        $activity->delete();

        return response()->json([
            'message' => 'activity deleted with success'
        ], 200);
    }
}
