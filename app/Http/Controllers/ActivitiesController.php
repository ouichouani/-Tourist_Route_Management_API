<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreactivitiesRequest;
use App\Http\Requests\UpdateactivitiesRequest;
use App\Models\activities;
use OpenApi\Attributes as OA;

class ActivitiesController extends Controller
{
    #[OA\Get(
        path: '/api/activities',
        summary: 'List activities',
        tags: ['Activities'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function index()
    {
        return response()->json([
            'data' => activities::all(),
        ], 200);
    }

    #[OA\Post(
        path: '/api/activities',
        summary: 'Create activity',
        tags: ['Activities'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'description'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', maxLength: 255),
                    new OA\Property(property: 'description', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(StoreactivitiesRequest $request)
    {
        $activities = activities::create($request->validated());

        return response()->json([
            'data' => $activities,
            'message' => 'activity created with success'

        ], 201);
    }

    #[OA\Get(
        path: '/api/activities/{activity}',
        summary: 'Show activity',
        tags: ['Activities'],
        parameters: [
            new OA\Parameter(
                name: 'activity',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
        ]
    )]
    public function show(activities $activity)
    {
        return response()->json([
            'data' => $activity,
        ], 200);
    }

    #[OA\Put(
        path: '/api/activities/{activity}',
        summary: 'Update activity',
        tags: ['Activities'],
        parameters: [
            new OA\Parameter(
                name: 'activity',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', maxLength: 255),
                    new OA\Property(property: 'description', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(UpdateactivitiesRequest $request, activities $activity)
    {
        $activity->update($request->validated());
        return response()->json([
            'data' => $activity->fresh(),
            'message' => 'activity updated with success'

        ]);
    }

    #[OA\Delete(
        path: '/api/activities/{activity}',
        summary: 'Delete activity',
        tags: ['Activities'],
        parameters: [
            new OA\Parameter(
                name: 'activity',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
        ]
    )]
    public function destroy(activities $activity)
    {
        $activity->delete();

        return response()->json([
            'message' => 'activity deleted with success'
        ], 200);
    }
}
