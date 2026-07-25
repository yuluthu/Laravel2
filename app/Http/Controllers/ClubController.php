<?php

namespace App\Http\Controllers;

use App\Club;
use App\Http\Requests\Clubs\StoreClubRequest;
use App\Http\Requests\Clubs\UpdateClubRequest;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Club::with('teams')->where('active', 1)->orderBy('name')->get()->withRelationshipAutoloading());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClubRequest $request)
    {
        $club = Club::factory()->make($request->input('data'));
        $club->save();

        return $club;
    }

    /**
     * Display the specified resource.
     */
    public function show(club $club)
    {
        return $club;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClubRequest $request, club $club)
    {
        $club->update($request->input('data'));

        if ($club->isDirty()) {
            $club->save();
        }

        return $club;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(club $club)
    {
        //
    }
}
