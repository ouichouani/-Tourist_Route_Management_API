<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredishesRequest;
use App\Http\Requests\UpdatedishesRequest;
use App\Models\dishes;
use OpenApi\Attributes as OA;

class DishesController extends Controller
{
    #[OA\Get(
        path: '/api/dishes',
        summary: 'List dishes',
        tags: ['Dishes'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function index()
    {
        return response()->json([
            'data' => dishes::all(),
        ]);
    }

    #[OA\Post(
        path: '/api/dishes',
        summary: 'Create dish',
        tags: ['Dishes'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'price'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', maxLength: 255),
                    new OA\Property(property: 'price', type: 'number', minimum: 0),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(StoredishesRequest $request)
    {
        $dishes = dishes::create($request->validated());

        return response()->json([
            'data' => $dishes,
            'message' => 'dish created with success'

        ], 201);
    }

    #[OA\Get(
        path: '/api/dishes/{dishes}',
        summary: 'Show dish',
        tags: ['Dishes'],
        parameters: [
            new OA\Parameter(
                name: 'dishes',
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
    public function show(dishes $dishes)
    {
        return response()->json([
            'data' => $dishes,
        ]);
    }

    #[OA\Put(
        path: '/api/dishes/{dishes}',
        summary: 'Update dish',
        tags: ['Dishes'],
        parameters: [
            new OA\Parameter(
                name: 'dishes',
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
                    new OA\Property(property: 'price', type: 'number', minimum: 0),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(UpdatedishesRequest $request, dishes $dishes)
    {
        $dishes->update($request->validated());

        return response()->json([
            'data' => $dishes->fresh(),
            'message' => 'dish updated with success'

        ]);
    }

    #[OA\Delete(
        path: '/api/dishes/{dishes}',
        summary: 'Delete dish',
        tags: ['Dishes'],
        parameters: [
            new OA\Parameter(
                name: 'dishes',
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
    public function destroy(dishes $dishes)
    {
        $dishes->delete();

        return response()->json([
            'message' => 'dish deleted with success'

        ], 200);
    }
}
