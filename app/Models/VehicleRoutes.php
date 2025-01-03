<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleRoutes extends Model
{
    use HasFactory;
    protected $table = 'vehicle_routes';

    public $timestamps = false;

    protected $fillable = [
        'route_id',
        'vehicle_id',
        
    ];
    
}
