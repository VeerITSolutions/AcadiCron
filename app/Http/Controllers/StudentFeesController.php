<?php

namespace App\Http\Controllers;

use App\Models\StudentFeesMaster;
use Illuminate\Http\Request; // Add this line
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
