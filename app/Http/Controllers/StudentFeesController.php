<?php

namespace App\Http\Controllers;

use App\Models\StudentFeesMaster;
use App\Models\StudentSession;
use Illuminate\Http\Request; // Add this line
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class StudentFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null, $role = null)
    {
        $student_session_id = $request->id;


        $studentDueFees = $this->getStudentFees($student_session_id) ?? []; // Replace with actual query logic

        $studentDiscounts = $this->getStudentFeesDiscount($student_session_id) ?? [];; // Replace with actual query logic

        $currencySymbol = "₹"; // Replace with your currency symbol logic

        return response()->json([
            'student_due_fees' => $studentDueFees,
            'student_discount_fees' => $studentDiscounts,
            'totals' => [
                'amount' => 0, // Total amount
                'paid' => 0,   // Total paid
                'discount' => 0, // Total discount
                'fine' => 0,   // Total fine
                'balance' => 0 // Remaining balance
            ],
            'currency_symbol' => $currencySymbol
        ]);
    }

    public function getStudentFees($student_session_id)
    {
        // Fetch the student fees along with the fee group names
        $result = DB::table('student_fees_master')
            ->join('fee_session_groups', 'student_fees_master.fee_session_group_id', '=', 'fee_session_groups.id')
            ->join('fee_groups', 'fee_groups.id', '=', 'fee_session_groups.fee_groups_id')
            ->where('student_session_id', $student_session_id)
            ->select('student_fees_master.*', 'fee_groups.name')
            ->orderBy('student_fees_master.id')
            ->get();

        if ($result->isNotEmpty()) {
            foreach ($result as $result_value) {
                $fee_session_group_id = $result_value->fee_session_group_id;
                $student_fees_master_id = $result_value->id;

                // Assuming this is a method you have that will return the due fee
                $result_value->fees = $this->getDueFeeByFeeSessionGroup($fee_session_group_id, $student_fees_master_id);

                // Check if the fee is system related and update the amount
                if ($result_value->is_system != 0 && isset($result_value->fees[0])) {
                    $result_value->fees[0]->amount = $result_value->amount;
                }
            }
        }

        return $result;
    }

    public function getStudentFeesDiscount($student_session_id = null)
    {
        $result = DB::table('student_fees_discounts')
            ->join('fees_discounts', 'fees_discounts.id', '=', 'student_fees_discounts.fees_discount_id')
            ->where('student_fees_discounts.student_session_id', $student_session_id)
            ->select(
                'student_fees_discounts.id',
                'student_fees_discounts.student_session_id',
                'student_fees_discounts.status',
                'student_fees_discounts.payment_id',
                'student_fees_discounts.description as student_fees_discount_description',
                'student_fees_discounts.fees_discount_id',
                'fees_discounts.name',
                'fees_discounts.code',
                'fees_discounts.amount',
                'fees_discounts.description',
                'fees_discounts.session_id'
            )
            ->orderBy('student_fees_discounts.id')
            ->get();

        return $result->toArray(); // Return the result as an array
    }

    public function getDueFeeByFeeSessionGroup($fee_session_groups_id, $student_fees_master_id)
    {
        $result = DB::table('student_fees_master')
            ->join('fee_session_groups', 'fee_session_groups.id', '=', 'student_fees_master.fee_session_group_id')
            ->join('fee_groups_feetype', 'fee_groups_feetype.fee_session_group_id', '=', 'fee_session_groups.id')
            ->join('fee_groups', 'fee_groups.id', '=', 'fee_groups_feetype.fee_groups_id')
            ->join('feetype', 'feetype.id', '=', 'fee_groups_feetype.feetype_id')
            ->leftJoin('student_fees_deposite', function ($join) {
                $join->on('student_fees_deposite.student_fees_master_id', '=', 'student_fees_master.id')
                    ->on('student_fees_deposite.fee_groups_feetype_id', '=', 'fee_groups_feetype.id');
            })
            ->where('student_fees_master.fee_session_group_id', $fee_session_groups_id)
            ->where('student_fees_master.id', $student_fees_master_id)
            ->select(
                'student_fees_master.*',
                'fee_groups_feetype.id as fee_groups_feetype_id',
                'fee_groups_feetype.amount',
                'fee_groups_feetype.due_date',
                'fee_groups_feetype.fine_amount',
                'fee_groups_feetype.fee_groups_id',
                'fee_groups.name',
                'fee_groups_feetype.feetype_id',
                'feetype.code',
                'feetype.type',
                DB::raw('IFNULL(student_fees_deposite.id, 0) as student_fees_deposite_id'),
                DB::raw('IFNULL(student_fees_deposite.amount_detail, 0) as amount_detail')
            )
            ->orderBy('fee_groups_feetype.due_date', 'ASC')
            ->get();

        return $result;
    }


    public function getDueFeeByFeeSessionGroupFeetype(Request $request)
    {

        $fee_session_groups_id = $request->input('fee_session_groups_id');
        $student_fees_master_id = $request->input('student_fees_master_id');
        $fee_groups_feetype_id = $request->input('fee_groups_feetype_id');

        $studentfeesmaster = new StudentFeesMaster();
        $getdata = $studentfeesmaster->getDueFeeByFeeSessionGroupFeetype($fee_session_groups_id, $student_fees_master_id, $fee_groups_feetype_id);

        $getdata = `<html>
            <p>Hello</p>
        </html>`;


        return response()->json($getdata);


        // returns a single row
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
