<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendNotification extends Model
{
    use HasFactory;
    protected $table = "send_notification";
    protected $fillable = [
'title',
'publish_date',
'date',
'message',
'visible_student',
'visible_staff',
'visible_parent',
'created_by',
'created_id',
'is_active',
'created_at',
'updated_at',
'path',
'class_id',
'secid'];










}
