<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredistinationRequest;
use App\Http\Requests\UpdatedistinationRequest;
use App\Models\distination;
use OpenApi\Attributes as OA;

class DistinationController extends Controller
{
    #[OA\Get(
        path: '/api/distinations',
        summary: 'List distinations',
        tags: ['Distination'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function index()
    {
        $distinations = distination::with(['dishes' , "places" , "activities"])->get() ;
        return response()->json([
            'data' => $distinations,
        ]);
    }

    #[OA\Post(
        path: '/api/distinations',
        summary: 'Create distination',
        tags: ['Distination'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'accommodation', 'dishes', 'places', 'activities'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', maxLength: 255),
                    new OA\Property(property: 'accommodation', type: 'string', maxLength: 255),
                    new OA\Property(
                        property: 'dishes',
                        type: 'array',
                        items: new OA\Items(type: 'integer')
                    ),
                    new OA\Property(
                        property: 'places',
                        type: 'array',
                        items: new OA\Items(type: 'integer')
                    ),
                    new OA\Property(
                        property: 'activities',
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
    public function store(StoredistinationRequest $request)
    {
        $distination = distination::create($request->safe()->except(['dishes' , 'places' , 'activities']));

        $distination->dishes()->attach($request->dishes) ;
        $distination->places()->attach($request->places) ;
        $distination->activities()->attach($request->activities) ;

        return response()->json([
            'data' => $distination,
            'message' => 'destination created with success'

        ], 201);
    }

    #[OA\Get(
        path: '/api/distinations/{distination}',
        summary: 'Show distination',
        tags: ['Distination'],
        parameters: [
            new OA\Parameter(
                name: 'distination',
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
    public function show(distination $distination)
    {
        return response()->json([
            'data' => $distination->load(['dishes' , 'places' , 'activities']),
        ]);
    }

    #[OA\Put(
        path: '/api/distinations/{distination}',
        summary: 'Update distination',
        tags: ['Distination'],
        parameters: [
            new OA\Parameter(
                name: 'distination',
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
                    new OA\Property(property: 'accommodation', type: 'string', maxLength: 255),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(UpdatedistinationRequest $request, distination $distination)
    {
        $distination->update($request->safe()->except(['places' , 'activities' , 'dishes']));

        $distination->places()->sync($request->places) ;
        $distination->activities()->sync($request->activities) ;
        $distination->dishes()->sync($request->dishes) ;

        return response()->json([
            'data' => $distination->load(['dishes' , 'places' , 'activities']),
            'message' => 'destination updated with success'

        ]);
    }

    #[OA\Delete(
        path: '/api/distinations/{distination}',
        summary: 'Delete distination',
        tags: ['Distination'],
        parameters: [
            new OA\Parameter(
                name: 'distination',
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
    public function destroy(distination $distination)
    {
        $distination->delete();

        return response()->json([
            'message' => 'destination deleted with success'
        ], 200);
    }
}
