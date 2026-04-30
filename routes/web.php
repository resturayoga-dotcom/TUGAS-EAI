<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;

Route::get('/buses', [BusController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});
