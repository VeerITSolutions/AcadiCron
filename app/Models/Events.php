<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;


    protected $table = 'events';

    public $timestamps = false;
    
    protected $fillable = [
        'event_title',
        'event_description',
        'start_date',
        'end_date',
        'event_type',
        'event_color',
        'event_for',
        'role_id',
        'is_active',
    ];
    
}

