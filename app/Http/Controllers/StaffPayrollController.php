<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffPayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $month = null, $year = null, $emp_name = null, $role = null)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided


        $selectedRole = $request->input('selectedRole');
        $selectedMonth = $request->input('selectedMonth');
        $selectedYear = $request->input('selectedYear');
        $keyword = $request->input('keyword');
        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Build the query with the necessary joins and conditions
        $query = DB::table('staff')
            ->leftJoin('staff_payslip', function ($join) use ($month, $year) {
                $join->on('staff.id', '=', 'staff_payslip.staff_id');
            })
            ->leftJoin('department', 'department.id', '=', 'staff.department')
            ->leftJoin('staff_roles', 'staff_roles.staff_id', '=', 'staff.id')
            ->leftJoin('roles', 'staff_roles.role_id', '=', 'roles.id')
            ->leftJoin('staff_designation', 'staff_designation.id', '=', 'staff.designation')
            ->select([
                'staff_payslip.status',
                DB::raw('IFNULL(staff_payslip.id, 0) as payslip_id'),
                'staff.*',
                'roles.name as user_type',
                'roles.id as role_id',
                'staff_designation.designation as designation',
                'department.department_name as department'
            ])
            ->where('staff.is_active', 1);

            if (!empty($selectedMonth) && !empty($selectedYear)) {
                $query->where(function($query) use ($selectedMonth, $selectedYear) {
                    $query->where('staff_payslip.month', '=', $selectedMonth)
                          ->where('staff_payslip.year', '=', $selectedYear);
                });
            }

            if (!empty($keyword)) {
                $query->where(function($q) use ($keyword) {
                    $q->where('staff.name', 'like', '%' . $keyword . '%')
                      ->orWhereRaw('CONCAT(staff.name, " ", staff.surname) like ?', ['%' . $keyword . '%']);
                });
            }


            if (!empty($selectedRole)) {
                $query->where('roles.id', $selectedRole );
            }


        // Apply pagination
        $data = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Return paginated data with additional pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->perPage(), // Number of rows per page
            'currentPage' => $data->currentPage(), // Current page
            'lastPage' => $data->lastPage(), // Total number of pages
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
