<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniEvents extends Model
{
    use HasFactory;

    protected $table = 'alumni_events';

    public $timestamps = false;

    protected $fillable = [
       'title',
        'event_for',
        'session_id',
        'class_id',
        'section',
        'from_date',
        'to_date',
        'note',
        'photo',
        'is_active',
        'event_notification_message',
        'show_onwebsite',
    ];
}
