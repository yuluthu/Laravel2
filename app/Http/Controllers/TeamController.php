<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Models\Team;
use App\Models\Club;
use Illuminate\Support\Arr;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Team::listWithRelated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $requestData = Arr::except($request->input('data'), 'club');
        $requestData['club_id'] = Club::findOrFail($request->input('data.club'));

        $team = Team::factory()->make($requestData);
        $team->save();

        return $team->findWithRelated($team->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return $team->findWithRelated($team->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $requestData = Arr::except($request->input('data'), 'club');
        if ($request->has('club')) {
            $requestData['club_id'] = Club::findOrFail($request->input('data.club'))->id;
        }

        $team->update($requestData);

        if ($team->isDirty()) {
            $team->save();
        }

        return $team->findWithRelated($team->id);
    }

    public function listTournaments(Team $team)
    {
        return response()->json($team->with('tournaments')->find($team->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
