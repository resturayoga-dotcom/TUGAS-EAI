<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;

class BusController extends Controller
{
    public function index(Request $request)
{
    $query = Bus::query();


    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('route', 'like', '%' . $request->search . '%');
    }

    $buses = $query->paginate(10);

    return response()->json([
        'success' => true,
        'data' => $buses
    ]);
}

public function show($id)
{
    $bus = Bus::find($id);

    if (!$bus) {
        return response()->json([
            'success' => false,
            'message' => 'Bus not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $bus
    ]);
}
}
