<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRoute extends Model
{
    use HasFactory;

    protected $table = 'transport_route';

    protected $fillable = ['route_title', 'no_of_vehicle', 'fare', 'note', 'is_active', 'created_at', 'updated_at'];
}
