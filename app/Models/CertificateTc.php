<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTc extends Model
{
    use HasFactory;
    protected $table = 'certificate_tc';


    protected $fillable = [
        'student_id',
        'tc_no',
    ];
}
