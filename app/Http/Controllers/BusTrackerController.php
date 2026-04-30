<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusTrackerController extends Controller
{
    
    public function index()
    {
        $buses = Bus::all();
        return view('tracker.index', compact('buses'));
    }

   
    public function admin()
    {
        $buses = Bus::all();
        return view('admin.index', compact('buses'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'bus_number' => 'required|unique:buses',
            'route_name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'status' => 'required'
        ]);

        Bus::create($request->all());

        return redirect()->back()->with('success', 'Bus added!');
    }

   
    public function update(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);

        $bus->update($request->all());

        return redirect()->back()->with('success', 'Bus updated!');
    }

    
    public function destroy($id)
    {
        Bus::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Bus deleted!');
    }

   
    public function updateLocation(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);

        $bus->update([
            'latitude' => $request->lat,
            'longitude' => $request->lng
        ]);

        return response()->json(['message' => 'Location updated']);
    }
}