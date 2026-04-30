<?php

namespace App\Http\Controllers;

use App\Models\Bus; 
use Illuminate\Http\Request;

class BusTrackerController extends Controller {
    
    public function index() {

        $buses = Bus::all(); 


        return view('tracker.index', compact('buses'));
    }

    public function updateLocation(Request $request, $id) {
        $bus = Bus::findOrFail($id);
        $bus->update([
            'latitude' => $request->lat,
            'longitude' => $request->lng
        ]);
        return response()->json(['message' => 'Location updated']);
    }
}