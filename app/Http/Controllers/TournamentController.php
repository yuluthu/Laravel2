<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tournaments\StoreTournamentRequest;
use App\Http\Requests\Tournaments\UpdateTournamentRequest;
use App\Models\Tournament;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Tournament::listWithRelated());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        $tournament = Tournament::factory()->make($request->input('data'));

        $tournament['date_start'] = $tournament->formatDate(new \DateTime($request->input('data.date_start')));
        $tournament['date_end'] = $tournament->formatDate(new \DateTime($request->input('data.date_end')));

        $tournament->save();

        return $tournament->findWithRelated($tournament->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        return $tournament->findWithRelated($tournament->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {

        $tournament->update($request->input('data'));

        if ($tournament->isDirty()) {
            $tournament->save();
        }

        return $tournament->findWithRelated($tournament->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        //
    }
}
