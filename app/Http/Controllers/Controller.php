<?php

namespace App\Http\Controllers;

abstract class Controller
{
     public function index() {
        $buses = Bus::all();
        return view('tracker.index', compact('buses'));
    }
}
