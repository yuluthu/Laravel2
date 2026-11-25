<?php

use App\Http\Controllers\BoardController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function (BoardController $board) {
    return inertia('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'board' => $board->payload(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
