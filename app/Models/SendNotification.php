<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendNotification extends Model
{
    use HasFactory;
    protected $table = "send_notification";
    protected $fillable = ['date','message', 'message_to', 'publish_date', 'title', 'path'];
}
