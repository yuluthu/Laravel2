<?php

namespace App\Http\Controllers;

use App\game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

class GameController extends Controller
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
    public function store(StoreGameRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(game $game)
    {
        //
    }
}
