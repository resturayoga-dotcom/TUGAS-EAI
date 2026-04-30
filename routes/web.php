<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusTrackerController;
use App\Http\Controllers\ProfileController;


// halaman utama (tracker)
Route::get('/', [BusTrackerController::class, 'index'])->name('home');




Route::middleware(['auth', 'verified'])->group(function () {

    // dashboard default (redirect biar ga kepake)
    Route::get('/dashboard', function () {
        return redirect('/');
    })->name('dashboard');

    // profile bawaan breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'admin'])->group(function () {

    // dashboard admin
    Route::get('/admin', [BusTrackerController::class, 'admin'])->name('admin.dashboard');

    // CRUD BUS
    Route::post('/bus', [BusTrackerController::class, 'store'])->name('bus.store');
    Route::put('/bus/{id}', [BusTrackerController::class, 'update'])->name('bus.update');
    Route::delete('/bus/{id}', [BusTrackerController::class, 'destroy'])->name('bus.destroy');

});



require __DIR__.'/auth.php';