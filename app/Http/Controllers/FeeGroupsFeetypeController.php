<?php

namespace App\Http\Controllers;

use App\Models\FeeGroupsFeetype;
use App\Models\FeeSessionGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeGroupsFeetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        $page = (int) $page;
        $perPage = (int) $perPage;

        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }

        $data = FeeGroupsFeetype::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

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
        $validatedData = $request->all();

        // Simulate `group_exists()` logic: fetch parent ID based on fee_groups_id
        $feeSessionGroupId = DB::table('fee_session_groups')
            ->where('fee_groups_id', $validatedData['fees_group'])
            ->where('session_id', $validatedData['session_id'])
            ->value('id');

        if (empty($feeSessionGroupId)) {
            $FeeGroupsFeetype = new FeeSessionGroups();

            $FeeGroupsFeetype->fee_groups_id = $validatedData['fees_group'];
            $FeeGroupsFeetype->session_id = $validatedData['session_id'];
            $FeeGroupsFeetype->is_active = 'no'; // Default to 'no' if not provided
            $FeeGroupsFeetype->save();
            $feeSessionGroupId = $FeeGroupsFeetype->id; // Get the newly created ID
        }


        // Create and save the record
        $FeeGroupsFeetype = new FeeGroupsFeetype();
        $FeeGroupsFeetype->fee_session_group_id = $feeSessionGroupId;
        $FeeGroupsFeetype->fee_groups_id = $validatedData['fees_group'];
        $FeeGroupsFeetype->feetype_id = $validatedData['fees_type'];
        $FeeGroupsFeetype->session_id = $validatedData['session_id'];

        $FeeGroupsFeetype->due_date = $validatedData['due_date'];
        $FeeGroupsFeetype->amount = $validatedData['amount'];
        $FeeGroupsFeetype->fine_type = $validatedData['fine_type'];
        $FeeGroupsFeetype->fine_percentage = $validatedData['percentage'] ?? 0; // Default to 0 if not provided
        $FeeGroupsFeetype->fine_amount = $validatedData['fine_amount'];

        $FeeGroupsFeetype->save();

        return response()->json([
            'success' => true,
            'message' => 'Saved successfully',
            'data' => $FeeGroupsFeetype,
        ], 201);
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
        $validatedData = $request->all();
        // Simulate `group_exists()` logic: fetch parent ID based on fee_groups_id
        $feeSessionGroupId = DB::table('fee_session_groups')
            ->where('fee_groups_id', $validatedData['fees_group'])
            ->where('session_id', $validatedData['selectedSessionId'])
            ->value('id');

        if (empty($feeSessionGroupId)) {
            $FeeGroupsFeetype = new FeeSessionGroups();

            $FeeGroupsFeetype->fee_groups_id = $validatedData['fees_group'];
            $FeeGroupsFeetype->session_id = $validatedData['selectedSessionId'];
            $FeeGroupsFeetype->is_active = 'no'; // Default to 'no' if not provided
            $FeeGroupsFeetype->save();
            $feeSessionGroupId = $FeeGroupsFeetype->id; // Get the newly created ID
        }


        $FeeGroupsFeetype = FeeGroupsFeetype::findOrFail($id);
        $FeeGroupsFeetype->fee_session_group_id = $feeSessionGroupId;
        $FeeGroupsFeetype->fee_groups_id = $validatedData['fees_group'];
        $FeeGroupsFeetype->feetype_id = $validatedData['fees_type'];
        $FeeGroupsFeetype->session_id = $validatedData['selectedSessionId'];

        $FeeGroupsFeetype->due_date = $validatedData['due_date'];
        $FeeGroupsFeetype->amount = $validatedData['amount'];
        $FeeGroupsFeetype->fine_type = $validatedData['fine_type'];
        $FeeGroupsFeetype->fine_percentage = $validatedData['percentage'] ?? 0; // Default to 0 if not provided
        $FeeGroupsFeetype->fine_amount = $validatedData['fine_amount'];


        $FeeGroupsFeetype->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'FeeGroupsFeetype' => $FeeGroupsFeetype,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $FeeGroupsFeetype = FeeGroupsFeetype::findOrFail($id);

            $FeeGroupsFeetype->delete();

            return response()->json(['success' => true, 'message' => ' deleted successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => ' deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
