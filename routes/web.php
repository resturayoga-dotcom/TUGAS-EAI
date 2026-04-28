<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusTrackerController;


Route::get('/', [BusTrackerController::class, 'index'])->name('tracker.index');

Route::post('/bus/update/{id}', [BusTrackerController::class, 'updateLocation']);

Route::get('/', function () {
    return view('welcome');
});
