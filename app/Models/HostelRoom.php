<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelRoom extends Model
{
    use HasFactory;

    protected $table = 'hostel_rooms';

    protected $fillable = ['hostel_id', 'room_type_id', 'room_no', 'no_of_bed', 'cost_per_bed', 'title', 'description', 'created_at', 'updated_at'];
}
