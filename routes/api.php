<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\DistinationController;
use App\Http\Controllers\ItinerarieController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController; //
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json(['hello a zin'], 203);
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/me', [UserController::class, 'show']);
    
    
        


    
    Route::get('itineraries/filter', [ItinerarieController::class, 'filter']);

    Route::apiResource('categories', CategoryController::class)->missing(function (){return response()->json(['message' => "category not found"] , 404) ;}) ;
    Route::apiResource('distinations', DistinationController::class)->missing(function (){return response()->json(['message' => "category not found"] , 404) ;}) ;
    Route::apiResource('itineraries', ItinerarieController::class)->missing(function (){return response()->json(['message' => "category not found"] , 404) ;}) ;
    Route::apiResource('places', PlacesController::class)->missing(function (){return response()->json(['message' => "category not found"] , 404) ;}) ;
    Route::apiResource('dishes', DishesController::class)->missing(function (){return response()->json(['message' => "category not found"] , 404) ;}) ;
    Route::apiResource('activities', ActivitiesController::class)->missing(function (){return response()->json(['message' => "category not found"] , 404) ;}) ;
});



