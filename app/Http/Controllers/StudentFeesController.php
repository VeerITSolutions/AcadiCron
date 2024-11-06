<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null, $role = null)
    {
        // Retrieve pagination parameters with defaults
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);
    
        // Define the student session ID (replace with your logic for obtaining the ID)
        $studentSessionId = $id;
    
        // Get fee IDs from the request (e.g., comma-separated)
        $feeIds = $request->input('feeIds');
    
        // Call getStudentFeesArray with pagination
        $paginatedData = $this->getStudentFeesArray($studentSessionId, $feeIds, $page, $perPage);
    
        // Return a JSON response with pagination details
        return response()->json([
            'success' => true,
            'data' => $paginatedData->items(), // Only current page data
            'pagination' => [
                'current_page' => $paginatedData->currentPage(),
                'per_page' => $paginatedData->perPage(),
                'total' => $paginatedData->total(),
                'last_page' => $paginatedData->lastPage(),
            ],
            'message' => 'Student fees retrieved successfully.'
        ], 200);
    }

    // Define the getStudentFeesArray method in the same controller
    public function getStudentFeesArray($studentSessionId, $ids = null, $page = 1, $perPage = 10)
    {
        $idsArray = explode(',', $ids);

        $query = DB::table('feemasters')
            ->leftJoin('feetype', 'feemasters.feetype_id', '=', 'feetype.id')
            ->leftJoin('feecategory', 'feetype.feecategory_id', '=', 'feecategory.id')
            ->leftJoin(DB::raw("(SELECT student_fees.id, student_fees.payment_mode, student_fees.feemaster_id, student_fees.amount_fine, student_fees.amount_discount, student_fees.date, student_fees.student_session_id FROM student_fees, student_session WHERE student_fees.student_session_id = student_session.id AND student_session.id = " . DB::getPdo()->quote($studentSessionId) . ") AS student_fees"), 'student_fees.feemaster_id', '=', 'feemasters.id')
            ->whereIn('feemasters.id', $idsArray)
            ->select(
                'feemasters.id as feemastersid',
                'feemasters.amount as amount',
                DB::raw("IFNULL(student_fees.id, 'xxx') as invoiceno"),
                DB::raw("IFNULL(student_fees.payment_mode, 'xxx') as payment_mode"),
                DB::raw("IFNULL(student_fees.amount_discount, 'xxx') as discount"),
                DB::raw("IFNULL(student_fees.amount_fine, 'xxx') as fine"),
                DB::raw("IFNULL(student_fees.date, 'xxx') as date"),
                'feetype.type',
                'feecategory.category'
            );

        // Paginate and return the results
        return $query->paginate($perPage, ['*'], 'page', $page);
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
