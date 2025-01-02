<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeesMaster extends Model
{
    use HasFactory;



    protected $table = 'student_fees_master';
    public $timestamps = false;

    public function feeSessionGroup()
    {
        return $this->belongsTo(FeeSessionGroups::class, 'fee_session_group_id');
    }

    public function getDueFeeByFeeSessionGroup($feeSessionGroupId, $studentFeesMasterId)
    {
        // Add logic here to fetch due fees
        return []; // Placeholder
    }
}
