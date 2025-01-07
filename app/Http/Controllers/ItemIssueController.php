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
        $page = $request->input('page');
        $perPage = $request->input('perPage', 10);

        $page = (int) $page;
        $perPage = (int) $perPage;

        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }

        $data = ItemIssue::leftJoin('roles', 'item_issue.issue_type', '=', 'roles.id')
            ->orderBy('item_issue.id', 'desc')
            ->paginate($perPage, ['item_issue.*', 'roles.name as name'], 'page', $page);
        $message = '';

        return response()->json([
            'success' => true,
            'data' => $data->items(),
            'totalCount' => $data->total(),
            'rowsPerPage' => $data->lastPage(),
            'currentPage' => $data->currentPage(),
            'message' => $message,
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
        $ItemIssue->item_category_id = $validatedData[''];
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
        $ItemIssue->item_category_id = $validatedData[''];
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
