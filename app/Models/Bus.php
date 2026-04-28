<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
  use HasFactory;

  protected $fillable = [
    'bus_number',
    'route_name',
    'latitude',
    'longtitude',
    'status'
  ];


  // Accessor for a readable location string
    public function getCoordinatesAttribute() {
        return "{$this->latitude}, {$this->longitude}";
}

}