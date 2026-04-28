<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusTrackerController extends Controller
{
    // Show the main tracking map/list
    public function index() {
        $buses = Bus::all();
        return view('tracker.index', compact('buses'));
    }

    // API endpoint for real-time location updates
    public function updateLocation(Request $request, $id) {
        $bus = Bus::findOrFail($id);
        $bus->update([
            'latitude' => $request->lat,
            'longitude' => $request->lng
        ]);

        return response()->json(['message' => 'Location updated successfully']);
}

}