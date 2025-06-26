<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentFees extends Model
{
    use HasFactory;



    public function remove($id, $sub_invoice)
    {
        $record = DB::table('student_fees_deposite')->where('id', $id)->first();

        if ($record) {
            $amountDetail = json_decode($record->amount_detail, true);

            if (isset($amountDetail[$sub_invoice])) {
                unset($amountDetail[$sub_invoice]);

                if (!empty($amountDetail)) {
                    DB::table('student_fees_deposite')
                        ->where('id', $id)
                        ->update([
                            'amount_detail' => json_encode($amountDetail),
                        ]);
                } else {
                    DB::table('student_fees_deposite')->where('id', $id)->delete();
                }
            }
        }

        return true;
    }
}
