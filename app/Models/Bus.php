<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model {
    use HasFactory;

    protected $table = 'buses';

    protected $fillable = [
        'bus_number', 
        'route_name', 
        'latitude', 
        'longitude', 
        'status'
    ];
}