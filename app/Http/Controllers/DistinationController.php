<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredistinationRequest;
use App\Http\Requests\UpdatedistinationRequest;
use App\Models\distination;

class DistinationController extends Controller
{
    public function index()
    {
        $distinations = distination::with(['dishes' , "places" , "activities"])->get() ;
        return response()->json([
            'data' => $distinations,
        ]);
    }

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

    public function show(distination $distination)
    {
        return response()->json([
            'data' => $distination->load(['dishes' , 'places' , 'activities']),
        ]);
    }

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

    public function destroy(distination $distination)
    {
        $distination->delete();

        return response()->json([
            'message' => 'destination deleted with success'
        ], 200);
    }
}
