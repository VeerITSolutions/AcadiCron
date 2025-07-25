<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeHead;
use Illuminate\Support\Facades\Session;

class IncomeHeadController extends Controller
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
        $data = IncomeHead::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
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
        $incomeHeads = new IncomeHead();
        $incomeHeads->income_category = $validatedData['income_category'];
        $incomeHeads->description = $validatedData['description'];

        $incomeHeads->save();

        return response()->json([
            'success' => true,
            'message' => 'Income  saved successfully',
            'incomeHeads' => $incomeHeads,
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
        $incomeHeads = IncomeHead::findOrFail($id);
        $incomeHeads->income_category = $validatedData['income_category'];
        $incomeHeads->description = $validatedData['description'] ?? $incomeHeads->description;
        $incomeHeads->update();

        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'incomeHeads' => $incomeHeads,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $incomeHeads = IncomeHead::findOrFail($id);
            $incomeHeads->delete();
            return response()->json(['success' => true, 'message' => 'Income head deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Income head deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
