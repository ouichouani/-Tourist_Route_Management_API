<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreToVisitListRequest;
use App\Http\Requests\UpdateToVisitListRequest;
use App\Models\ToVisitList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ToVisitListController extends Controller
{
    #[OA\Get(
        path: '/api/to-visit-list',
        summary: 'Show to-visit list',
        tags: ['ToVisitList'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function show(Request $request): JsonResponse
    {
        $list = $request->user()->toVisitList()->with('itineraries')->first();

        if (!$list) {
            return response()->json([
                'message' => 'To-visit list not found',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'data' => $list,
        ]);
    }

    #[OA\Post(
        path: '/api/to-visit-list',
        summary: 'Create to-visit list',
        tags: ['ToVisitList'],
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function store(StoreToVisitListRequest $request): JsonResponse
    {
        $list = ToVisitList::firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

        $status = $list->wasRecentlyCreated ? 201 : 200;
        $message = $list->wasRecentlyCreated
            ? 'to-visit list created'
            : 'to-visit list already exists';

        return response()->json([
            'data' => $list,
            'message' => $message,
        ], $status);
    }

    #[OA\Delete(
        path: '/api/to-visit-list',
        summary: 'Delete to-visit list',
        tags: ['ToVisitList'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function delete(Request $request): JsonResponse
    {
        $list = $request->user()->toVisitList;

        if (!$list) {
            return response()->json([
                'message' => 'To-visit list not found',
            ], 404);
        }

        $list->delete();

        return response()->json([
            'message' => 'to-visit list deleted',
        ], 200);
    }

    #[OA\Post(
        path: '/api/to-visit-list/itineraries',
        summary: 'Add itinerary to to-visit list',
        tags: ['ToVisitList'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['itinerary_id'],
                properties: [
                    new OA\Property(property: 'itinerary_id', type: 'integer'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function addItinerary(UpdateToVisitListRequest $request): JsonResponse
    {
        $list = $request->user()->toVisitList;

        if (!$list) {
            return response()->json([
                'message' => 'To-visit list not found',
            ], 404);
        }

        $list->itineraries()->syncWithoutDetaching([$request->itinerary_id]);

        return response()->json([
            'data' => $list->load('itineraries'),
            'message' => 'itinerary added to to-visit list',
        ]);
    }

    #[OA\Delete(
        path: '/api/to-visit-list/itineraries',
        summary: 'Remove itinerary from to-visit list',
        tags: ['ToVisitList'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['itinerary_id'],
                properties: [
                    new OA\Property(property: 'itinerary_id', type: 'integer'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function removeItinerary(UpdateToVisitListRequest $request): JsonResponse
    {
        $list = $request->user()->toVisitList;

        if (!$list) {
            return response()->json([
                'message' => 'To-visit list not found',
            ], 404);
        }

        $list->itineraries()->detach($request->itinerary_id);

        return response()->json([
            'data' => $list->load('itineraries'),
            'message' => 'itinerary removed from to-visit list',
        ]);
    }
}