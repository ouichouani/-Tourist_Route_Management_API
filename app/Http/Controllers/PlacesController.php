<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreplacesRequest;
use App\Http\Requests\UpdateplacesRequest;
use App\Models\places;
use OpenApi\Attributes as OA;

class PlacesController extends Controller
{
    #[OA\Get(
        path: '/api/places',
        summary: 'List places',
        tags: ['Places'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function index()
    {
        return response()->json([
            'data' => places::all(),
        ]);
    }

    #[OA\Post(
        path: '/api/places',
        summary: 'Create place',
        tags: ['Places'],
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
    public function store(StoreplacesRequest $request)
    {
        $places = places::create($request->validated());

        return response()->json([
            'data' => $places,
            'message' => 'place created with success'

        ], 201);
    }

    #[OA\Get(
        path: '/api/places/{places}',
        summary: 'Show place',
        tags: ['Places'],
        parameters: [
            new OA\Parameter(
                name: 'places',
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
    public function show(places $places)
    {
        return response()->json([
            'data' => $places,
        ]);
    }

    #[OA\Put(
        path: '/api/places/{places}',
        summary: 'Update place',
        tags: ['Places'],
        parameters: [
            new OA\Parameter(
                name: 'places',
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
    public function update(UpdateplacesRequest $request, places $places)
    {
        $places->update($request->validated());

        return response()->json([
            'data' => $places->fresh(),
            'message' => 'place updated with success'

        ]);
    }

    #[OA\Delete(
        path: '/api/places/{places}',
        summary: 'Delete place',
        tags: ['Places'],
        parameters: [
            new OA\Parameter(
                name: 'places',
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
    public function destroy(places $places)
    {
        $places->delete();

        return response()->json([
            'message' => 'place deleted with success'
        ], 200);
    }
}
