<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getDueFeeByFeeSessionGroupFeetype($fee_session_groups_id, $student_fees_master_id, $fee_groups_feetype_id)
    {
        return DB::table('student_fees_master')
            ->join('fee_session_groups', 'fee_session_groups.id', '=', 'student_fees_master.fee_session_group_id')
            ->join('fee_groups_feetype', 'fee_groups_feetype.fee_session_group_id', '=', 'fee_session_groups.id')
            ->join('fee_groups', 'fee_groups.id', '=', 'fee_groups_feetype.fee_groups_id')
            ->join('feetype', 'feetype.id', '=', 'fee_groups_feetype.feetype_id')
            ->leftJoin('student_fees_deposite', function ($join) {
                $join->on('student_fees_deposite.student_fees_master_id', '=', 'student_fees_master.id')
                    ->on('student_fees_deposite.fee_groups_feetype_id', '=', 'fee_groups_feetype.id');
            })
            ->join('student_session', 'student_session.id', '=', 'student_fees_master.student_session_id')
            ->join('classes', 'classes.id', '=', 'student_session.class_id')
            ->join('sections', 'sections.id', '=', 'student_session.section_id')
            ->join('students', 'students.id', '=', 'student_session.student_id')
            ->where('student_fees_master.fee_session_group_id', $fee_session_groups_id)
            ->where('student_fees_master.id', $student_fees_master_id)
            ->where('fee_groups_feetype.id', $fee_groups_feetype_id)
            ->select([
                'student_fees_master.id',
                'student_fees_master.is_system',
                'student_fees_master.student_session_id',
                'student_fees_master.fee_session_group_id',
                'student_fees_master.amount as student_fees_master_amount',

                'fee_groups_feetype.id as fee_groups_feetype_id',
                'students.id as student_id',
                'students.firstname',
                'students.middlename',
                'students.lastname',
                'students.admission_no',
                'students.guardian_name',
                'students.father_name',

                'student_session.class_id',
                'student_session.section_id',
                'student_session.student_id',

                'classes.class',
                'sections.section',

                'fee_groups_feetype.amount',
                'fee_groups_feetype.due_date',
                'fee_groups_feetype.fine_amount',
                'fee_groups_feetype.fee_groups_id',

                'fee_groups.name',
                'fee_groups_feetype.feetype_id',
                'feetype.code',
                'feetype.type',

                DB::raw('IFNULL(student_fees_deposite.id, 0) as student_fees_deposite_id'),
                DB::raw('IFNULL(student_fees_deposite.amount_detail, 0) as amount_detail'),
            ])
            ->first(); // returns a single row
    }



    public function feeDepositCollectionsCIStyle(array $data): array
    {
        $collectedFees = [];

        foreach ($data as $item) {
            $masterId = $item['student_fees_master_id'];
            $typeId   = $item['fee_groups_feetype_id'];
            $detail   = $item['amount_detail'];

            $existing = DB::table('student_fees_deposite')
                ->where('student_fees_master_id', $masterId)
                ->where('fee_groups_feetype_id', $typeId)
                ->first();

            if ($existing) {
                $existingDetail = json_decode($existing->amount_detail, true) ?? [];
                $invNo = empty($existingDetail) ? 1 : (max(array_keys($existingDetail)) + 1);

                $detail['inv_no'] = $invNo;
                $existingDetail[$invNo] = $detail;

                DB::table('student_fees_deposite')
                    ->where('id', $existing->id)
                    ->update(['amount_detail' => json_encode($existingDetail)]);

                $collectedFees[] = ['invoice_id' => $existing->id, 'sub_invoice_id' => $invNo];
            } else {
                $detail['inv_no'] = 1;
                $dataToInsert = [
                    'student_fees_master_id' => $masterId,
                    'fee_groups_feetype_id'  => $typeId,
                    'amount_detail'          => json_encode(['1' => $detail]),
                ];

                $newId = DB::table('student_fees_deposite')->insertGetId($dataToInsert);

                $collectedFees[] = ['invoice_id' => $newId, 'sub_invoice_id' => 1];
            }
        }

        return $collectedFees;
    }
}
