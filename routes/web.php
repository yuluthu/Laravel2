<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::get('/token', function (Request $request) {

        $token = $request->user()->createToken('test');
    
        return ['token' => $token->plainTextToken];
    });
});

require __DIR__.'/settings.php';
