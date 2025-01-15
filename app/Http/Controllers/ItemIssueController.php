<?php

namespace App\Http\Controllers;

use App\Models\ItemIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get current page and items per page from the request
        $page = (int) $request->input('page', 1); // Default to page 1
        $perPage = (int) $request->input('perPage', 10); // Default items per page to 10
        
        // Validate the perPage value
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }
    
        // Query the database using Eloquent and relationships
    
        $data = ItemIssue::leftJoin('item', 'item.id', '=', 'item_issue.item_id')
            ->leftJoin('item_category', 'item_category.id', '=', 'item.item_category_id')
            ->leftJoin('staff', 'staff.id', '=', 'item_issue.issue_to')
            ->leftJoin('staff_roles', 'staff_roles.staff_id', '=', 'staff.id')
            ->leftJoin('roles', 'roles.id', '=', 'staff_roles.role_id')
            ->select(
                'item_issue.*',
                'item.name as name',
                'item.item_category_id',
                'item_category.item_category',
                'staff.employee_id',
                'staff.name as staff_name',
                'staff.surname',
                'roles.name as role_name'
            )
            ->orderBy('item_issue.id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
    
        // Return the paginated response
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Data for the current page
            'totalCount' => $data->total(), // Total items in the database
            'rowsPerPage' => $data->perPage(), // Items per page
            'currentPage' => $data->currentPage(), // Current page number
            'lastPage' => $data->lastPage(), // Total number of pages
        ], 200);
    }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new ItemIssue
        $ItemIssue = new ItemIssue();
        $ItemIssue->issue_type = $validatedData['issue_type'];
        $ItemIssue->issue_to = $validatedData['issue_to'];
        $ItemIssue->issue_by = $validatedData['issue_by'];
        $ItemIssue->issue_date = $validatedData['issue_date'];
        $ItemIssue->return_date = $validatedData['return_date'];
        $ItemIssue->item_category_id = $validatedData['item_category_id'];
        $ItemIssue->item_id = $validatedData['item_id'];
        $ItemIssue->quantity = $validatedData['quantity'];
        $ItemIssue->note = $validatedData['note'];

        $ItemIssue->save();

        return response()->json([
            'success' => true,
            'message' => 'ItemIssue  saved successfully',
            'ItemIssue' => $ItemIssue,
        ], 201); // 201 Created status code
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
        // Find the ItemIssue by id
        $validatedData = $request->all();

        $ItemIssue = ItemIssue::findOrFail($id);

        $ItemIssue->issue_type = $validatedData['issue_type'];
        $ItemIssue->issue_to = $validatedData['issue_to'];
        $ItemIssue->issue_by = $validatedData['issue_by'];
        $ItemIssue->issue_date = $validatedData['issue_date'];
        $ItemIssue->return_date = $validatedData['return_date'];
        $ItemIssue->item_category_id = $validatedData['item_category_id'];
        $ItemIssue->item_id = $validatedData['item_id'];
        $ItemIssue->quantity = $validatedData['quantity'];
        $ItemIssue->note = $validatedData['note'];

        $ItemIssue->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'ItemIssue' => $ItemIssue,
        ], 200); // 200 OK status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $Item = ItemIssue::findOrFail($id);

            $Item->delete();

            return response()->json(['success' => true, 'message' => 'Item Category  deleted successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
