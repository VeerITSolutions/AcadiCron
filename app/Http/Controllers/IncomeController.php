<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\IncomeHead;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Set session data
        Session::put('top_menu', 'Income');
        Session::put('sub_menu', 'income/index');
    
        // Pagination inputs from request
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided
    
        // Validate and ensure perPage is a valid integer
        $page = (int) $page;
        $perPage = (int) $perPage;
    
        // Ensure $perPage is within a reasonable range (1 to 100)
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default to 10 if invalid
        }
    
        // Fetch paginated income data
        $incomes = Income::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
    
        // Prepare the data for the response
        $data = [
            'title' => 'Add Income',
            'title_list' => 'Recent Incomes',
            'currency_symbol' => '$',
            'language' => 'en', 
            'incomelist' => $incomes->items(), 
            'totalCount' => $incomes->total(), 
            'rowsPerPage' => $incomes->lastPage(), 
            'currentPage' => $incomes->currentPage(), 
        ];
    
        return response()->json([
            'success' => true,
            'data' => $data['incomelist'],
            'totalCount' => $data['totalCount'],
            'rowsPerPage' => $data['rowsPerPage'],
            'currentPage' => $data['currentPage'],
            'message' => '', 
        ], 200);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();

        // Create a new income
        $income = new Income();
        $income->class_id = $validatedData['class_id'];
        $income->section_id = $validatedData['section_id'];
        $income->inc_head_id = $validatedData['inc_head_id'];
        $income->name = $validatedData['name'];
        $income->invoice_no = $validatedData['invoice_no'];
        $income->date = $validatedData['date'];
        $income->amount = $validatedData['amount'];
        $income->note = $validatedData['note'];
        $income->is_active = $validatedData['is_active'];
        $income->is_deleted = $validatedData['is_deleted'];
        $income->documents = $validatedData['documents'] ?? null;


        $income->save();

        return response()->json([
            'success' => true,
            'message' => 'Saved Successfully',
            'income' => $income,
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
    public function update(Request $request,string $id)
    {

        // Find the income by id
        $income = Income::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();

        // Update the income
        $income->update($validatedData);


        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'income' => $income,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $income = Income::findOrFail($id);

            $income->delete();

            return response()->json(['success' => true, 'message' => 'income deleted successfully']);
        } catch (\Exception $e) {
           
            return response()->json(['success' => false, 'message' => 'income deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
