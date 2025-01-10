<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onlineexam extends Model
{
    use HasFactory;


    protected $table = 'onlineexam';

    protected $fillable = ['exam', 'attempt', 'exam_from', 'exam_to', 'is_quiz', 'auto_publish_date', 'time_from', 'time_to', 'duration', 'passing_percentage', 'description', 'session_id', 'publish_result', 'is_active', 'is_marks_display', 'is_neg_marking', 'is_random_question', 'is_rank_generated', 'publish_exam_notification', 'publish_result_notification', 'created_at', 'updated_at'];
}
