<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;
use App\Models\category;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    #[OA\Get(
        path: '/api/categories',
        summary: 'List categories',
        tags: ['Category'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function index()
    {
        return response()->json([
            'data' => category::all(),
        ]);
    }

    #[OA\Post(
        path: '/api/categories',
        summary: 'Create category',
        tags: ['Category'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', maxLength: 255),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Created'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(StorecategoryRequest $request)
    {
        $category = category::create($request->validated());

        return response()->json([
            'data' => $category,
            'message' => 'cat created with success'
        ], 201);
    }

    #[OA\Get(
        path: '/api/categories/{category}',
        summary: 'Show category',
        tags: ['Category'],
        parameters: [
            new OA\Parameter(
                name: 'category',
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
    public function show(category $category)
    {
        return response()->json([
            'data' => $category,
        ]);
    }

    #[OA\Put(
        path: '/api/categories/{category}',
        summary: 'Update category',
        tags: ['Category'],
        parameters: [
            new OA\Parameter(
                name: 'category',
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
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK'),
            new OA\Response(response: 404, description: 'Not Found'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(UpdatecategoryRequest $request, category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'data' => $category->fresh(),
            'message' => 'cat updated with success'
        ]);
    }

    #[OA\Delete(
        path: '/api/categories/{category}',
        summary: 'Delete category',
        tags: ['Category'],
        parameters: [
            new OA\Parameter(
                name: 'category',
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
    public function destroy(category $category)
    {
        
        $category->delete();
        return response()->json(['message' => 'cat destroyed with success'], 200);
    }
}
