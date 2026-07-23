<?php

use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;

// v1 API
Route::middleware(['auth:sanctum'])->group(function () {
    // Route::apiResource('/v1/devices', DeviceController::class);
    Route::controller(DeviceController::class)->group(function () {
        Route::get('/v1/devices', 'index');
        Route::get('/v1/devices/{device}', 'show');
        Route::get('/v1/devices/{device}/status', 'status');
        Route::post('v1/devices/{device}/telemetry', 'updateTelemetry');
    });
});
