<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseHead;
use Illuminate\Support\Facades\Session;

class ExpenseHeadController extends Controller
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
        $data = ExpenseHead::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
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
        $expenseHead = new ExpenseHead();
        $expenseHead->exp_category = $validatedData['exp_category'];
        $expenseHead->description = $validatedData['description'];
       
        $expenseHead->save();

        return response()->json([
            'success' => true,
            'message' => 'Data saved successfully',
            'expenseHead' => $expenseHead,
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
        $expenseHead = ExpenseHead::findOrFail($id);
        $expenseHead->exp_category = $validatedData['exp_category'];
        $expenseHead->description = $validatedData['description'];
        $expenseHead->update();

        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'expenseHead' => $expenseHead,
        ], 200); 
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $expenseHead = ExpenseHead::findOrFail($id);
            $expenseHead->delete();
            return response()->json(['success' => true, 'message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
