<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

Route::get('/board', [BoardController::class, 'show']);

// v1 API
Route::middleware(['auth:sanctum'])->group(function () {
});
