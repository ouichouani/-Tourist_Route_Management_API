<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreitinerarieRequest;
use App\Http\Requests\UpdateitinerarieRequest;
use App\Models\itinerarie;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ItinerarieController extends Controller
{
    #[OA\Get(
        path: '/api/itineraries',
        summary: 'List itineraries',
        tags: ['Itinerarie'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function index()
    {
        return response()->json([
            'data' => itinerarie::all(),
        ]);
    }

    #[OA\Get(
        path: '/api/itineraries/filter',
        summary: 'Filter itineraries',
        tags: ['Itinerarie'],
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'category_id', type: 'integer'),
                    new OA\Property(property: 'duration_from', type: 'string', format: 'date'),
                    new OA\Property(property: 'duration_to', type: 'string', format: 'date'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
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

    #[OA\Post(
        path: '/api/itineraries',
        summary: 'Create itinerarie',
        tags: ['Itinerarie'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'duration_from', 'duration_to', 'destinations'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', maxLength: 255),
                    new OA\Property(property: 'duration_from', type: 'string', format: 'date'),
                    new OA\Property(property: 'duration_to', type: 'string', format: 'date'),
                    new OA\Property(property: 'image', type: 'string', maxLength: 255, nullable: true),
                    new OA\Property(property: 'category_id', type: 'integer', nullable: true),
                    new OA\Property(property: 'user_id', type: 'integer', nullable: true),
                    new OA\Property(
                        property: 'destinations',
                        type: 'array',
                        items: new OA\Items(type: 'integer')
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(StoreitinerarieRequest $request)
    {
        $itinerarie = itinerarie::create($request->safe()->except('destinations'));
        $itinerarie->destinations()->attach($request->destinations) ;


        return response()->json([
            'data' => $itinerarie->load('destinations'),
            'message' => 'itinerarie created with success'

        ], 201);
    }

    #[OA\Get(
        path: '/api/itineraries/{itinerarie}',
        summary: 'Show itinerarie',
        tags: ['Itinerarie'],
        parameters: [
            new OA\Parameter(
                name: 'itinerarie',
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
    public function show(itinerarie $itinerarie)
    {
        return response()->json([
            'data' => $itinerarie,
        ]);
    }

    #[OA\Put(
        path: '/api/itineraries/{itinerarie}',
        summary: 'Update itinerarie',
        tags: ['Itinerarie'],
        parameters: [
            new OA\Parameter(
                name: 'itinerarie',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string', maxLength: 255),
                    new OA\Property(property: 'duration_from', type: 'string', format: 'date'),
                    new OA\Property(property: 'duration_to', type: 'string', format: 'date'),
                    new OA\Property(property: 'image', type: 'string', maxLength: 255),
                    new OA\Property(property: 'category_id', type: 'integer', nullable: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(UpdateitinerarieRequest $request, itinerarie $itinerarie)
    {
        $itinerarie->update($request->validated());

        return response()->json([
            'data' => $itinerarie->fresh(),
            'message' => 'itinerarie updated with success'

        ]);
    }

    #[OA\Delete(
        path: '/api/itineraries/{itinerarie}',
        summary: 'Delete itinerarie',
        tags: ['Itinerarie'],
        parameters: [
            new OA\Parameter(
                name: 'itinerarie',
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
    public function destroy(itinerarie $itinerarie)
    {
        $itinerarie->delete();

        return response()->json([
            'message' => 'itinerarie deleted with success'
        ], 200);
    }
}







