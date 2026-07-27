<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameEventRequest;
use App\Http\Requests\UpdateGameEventRequest;
use App\Models\GameEvent;

class GameEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameEventRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GameEvent $gameEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameEventRequest $request, GameEvent $gameEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameEvent $gameEvent)
    {
        //
    }
}
