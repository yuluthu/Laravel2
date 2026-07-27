<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'club' => ClubController::class,
    'tournament' => TournamentController::class,
    'team' => TeamController::class,
    'game' => GameController::class,
]);
Route::get('/team/{team}/tournaments', [TeamController::class, 'listTournaments']);
