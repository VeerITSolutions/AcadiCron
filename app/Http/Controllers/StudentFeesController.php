<?php

namespace App\Http\Controllers;

use App\Models\StudentFeesMaster;
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
        $student_session_id = $request->student_session_id;

        // Fetching the student's fees along with fee group details
            $result = StudentFeesMaster::where('student_session_id', $student_session_id)
            ->join('fee_session_groups', 'student_fees_master.fee_session_group_id', '=', 'fee_session_groups.id')
            ->join('fee_groups', 'fee_groups.id', '=', 'fee_session_groups.fee_groups_id')
            ->select('student_fees_master.*', 'fee_groups.name')
            ->orderBy('student_fees_master.id')
            ->get();

        // Adding additional data by iterating over each result
        foreach ($result as $result_key => $result_value) {
            $fee_session_group_id = $result_value->fee_session_group_id;
            $student_fees_master_id = $result_value->id;

            // Assuming getDueFeeByFeeSessionGroup is a method to fetch due fees
            $result_value->fees = $this->getDueFeeByFeeSessionGroup($fee_session_group_id, $student_fees_master_id);

            // Adjusting the amount if 'is_system' is not zero
            if ($result_value->is_system != 0 && isset($result_value->fees[0])) {
                $result_value->fees[0]->amount = $result_value->amount;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $result,
        ], 200);
    }

    public function getStudentFees(Request $request, $id = null, $role = null)
    {
        $student_session_id = $request->student_session_id;

        // Fetching the student's fees along with fee group details
            $result = StudentFeesMaster::where('student_session_id', $student_session_id)
            ->join('fee_session_groups', 'student_fees_master.fee_session_group_id', '=', 'fee_session_groups.id')
            ->join('fee_groups', 'fee_groups.id', '=', 'fee_session_groups.fee_groups_id')
            ->select('student_fees_master.*', 'fee_groups.name')
            ->orderBy('student_fees_master.id')
            ->get();



        // Adding additional data by iterating over each result
        foreach ($result as $result_key => $result_value) {
            $fee_session_group_id = $result_value->fee_session_group_id;
            $student_fees_master_id = $result_value->id;

            // Assuming getDueFeeByFeeSessionGroup is a method to fetch due fees
            $result_value->fees = $this->getDueFeeByFeeSessionGroup($fee_session_group_id, $student_fees_master_id);

            // Adjusting the amount if 'is_system' is not zero
            if ($result_value->is_system != 0 && isset($result_value->fees[0])) {
                $result_value->fees[0]->amount = $result_value->amount;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $result,
        ], 200);
    }

    public function getDueFeeByFeeSessionGroup($fee_session_groups_id, $student_fees_master_id)
{
    // Building the query with Eloquent
    $result = StudentFeesMaster::where('student_fees_master.fee_session_group_id', $fee_session_groups_id)
        ->where('student_fees_master.id', $student_fees_master_id)
        ->join('fee_session_groups', 'fee_session_groups.id', '=', 'student_fees_master.fee_session_group_id')
        ->join('fee_groups_feetype', 'fee_groups_feetype.fee_session_group_id', '=', 'fee_session_groups.id')
        ->join('fee_groups', 'fee_groups.id', '=', 'fee_groups_feetype.fee_groups_id')
        ->join('feetype', 'feetype.id', '=', 'fee_groups_feetype.feetype_id')
        ->leftJoin('student_fees_deposite', function ($join) {
            $join->on('student_fees_deposite.student_fees_master_id', '=', 'student_fees_master.id')
                 ->on('student_fees_deposite.fee_groups_feetype_id', '=', 'fee_groups_feetype.id');
        })
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
