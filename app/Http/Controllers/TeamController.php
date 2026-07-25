<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Team;
use Illuminate\Support\Arr;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Team::with('club')->orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $requestData = Arr::except($request->input('data'), 'club');
        $requestData['clubId'] = Club::findOrFail($request->input('data.club'));

        $team = Team::factory()->make($requestData);
        $team->save();

        return $team;
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return $team;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $requestData = Arr::except($request->input('data'), 'club');
        if ($request->has('club')) {
            $requestData['clubId'] = Club::findOrFail($request->input('data.club'))->id;
        }

        $team->update($requestData);

        if ($team->isDirty()) {
            $team->save();
        }

        return $team;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
