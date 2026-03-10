<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoredishesRequest;
use App\Http\Requests\UpdatedishesRequest;
use App\Models\dishes;

class DishesController extends Controller
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
    public function store(StoredishesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(dishes $dishes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dishes $dishes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedishesRequest $request, dishes $dishes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dishes $dishes)
    {
        //
    }
}
