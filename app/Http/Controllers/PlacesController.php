<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreplacesRequest;
use App\Http\Requests\UpdateplacesRequest;
use App\Models\places;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreplacesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(places $places)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(places $places)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateplacesRequest $request, places $places)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(places $places)
    {
        //
    }
}
