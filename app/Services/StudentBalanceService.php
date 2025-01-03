<?php

namespace App\Services;

use App\Models\StudentFeeMaster;
use App\Models\StudentFeesMaster;

class StudentBalanceService
{
    public function findValueExists($array, $find)
    {
        foreach ($array as $item) {
            if ($item['student_session_id'] === $find) {
                return $item['amount'];
            }
        }
        return 0;
    }

    public function getPreviousStudentFees($studentSessionId)
    {
        $results = StudentFeesMaster::where('student_session_id', $studentSessionId)
            ->with('feeSessionGroup.feeGroup')
            ->orderBy('id')
            ->get();

        foreach ($results as $result) {
            $feeSessionGroupId = $result->fee_session_group_id;
            $studentFeesMasterId = $result->id;
            $result->fees = $result->getDueFeeByFeeSessionGroup($feeSessionGroupId, $studentFeesMasterId);

            if ($result->is_system != 0) {
                $result->fees[0]->amount = $result->amount;
            }
        }

        return $results;
    }

    public function calculateBalances($students, $balanceGroup)
    {
        $studentIds = $students->pluck('id')->toArray();
        $recordExists = $this->getBalanceMasterRecord($balanceGroup, $studentIds);

        foreach ($students as $student) {
            if (!empty($recordExists)) {
                $student->balance = $this->findValueExists($recordExists, $student->student_session_id);
            } else {
                $previousFees = $this->getPreviousStudentFees($student->student_previous_session_id);

                if (!empty($previousFees)) {
                    $totalFee = 0;
                    $deposit = 0;
                    $discount = 0;

                    foreach ($previousFees as $fee) {
                        foreach ($fee->fees as $eachFee) {
                            $totalFee += $eachFee->amount;

                            if (!empty($eachFee->amount_detail)) {
                                $amountDetails = json_decode($eachFee->amount_detail, true);
                                foreach ($amountDetails as $detail) {
                                    $deposit += $detail['amount'];
                                    $discount += $detail['amount_discount'];
                                }
                            }
                        }
                    }

                    $student->balance = $totalFee - ($deposit + $discount);
                } else {
                    $student->balance = 0;
                }
            }
        }

        return $students;
    }

    public function getBalanceMasterRecord($balanceGroup, $studentIds)
    {
        // Logic to fetch balance master record
        return []; // Placeholder
    }
}
