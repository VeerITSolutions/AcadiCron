<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;
    protected $table = 'vehicles';

    public $timestamps = false;

    protected $fillable = [
        'vehicle_no',
        'vehicle_model',
        'manufacture_year',
        'driver_name',
        'driver_licence',
        'driver_contact',
        'note',
    ];
    
}
