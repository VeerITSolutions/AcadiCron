<?php

namespace App\Http\Controllers;


use App\Models\Expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }
            if($request->selectedSearchType){
                $days = $request->selectedSearchType;

                $endDate = now(); // Current date and time
                $startDate = now()->subDays($days); // Calculate the date N days ago

                $data = Expenses::leftJoin('expense_head', 'expenses.exp_head_id', '=', 'expense_head.id')
                                ->whereBetween('expenses.created_at', [$startDate, $endDate])
                                ->orderBy('expenses.id', 'desc')
                                ->get();

                return response()->json([
                    'success' => true,
                    'data' => $data,
                ], 200);
            }
        // Paginate the students data
        // $data = Expenses::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $data = Expenses::leftJoin('expense_head', 'expenses.exp_head_id', '=', 'expense_head.id')
        ->orderBy('expenses.id', 'desc')
        ->paginate($perPage, ['expenses.*', 'expense_head.exp_category as exp_category'], 'page', $page);

        // Prepare the response message
        $message = '';

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->lastPage(), // Total number of pages
            'currentPage' => $data->currentPage(), // Current page
            'message' => $message,
        ], 200);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $validatedData = $request->all();


    $Expenses = new Expenses();
    $Expenses->exp_head_id = $validatedData['exp_head_id'];
    $Expenses->name = $validatedData['name'];
    $Expenses->invoice_no = $validatedData['invoice_no'];
    $Expenses->date = $validatedData['date'];
    $Expenses->amount = $validatedData['amount'];
    $Expenses->note = $validatedData['note'];

    // Handle file upload
    if ($request->hasFile('documents')) {
        $file = $request->file('documents');
        $imageName = 'expense_' . time() . '.' . $file->getClientOriginalExtension(); // Example name
        $imageSubfolder = 'school_expense'; // Example subfolder
        $full_path = 1; // Flag for full path usage
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path); // Custom uploadImage function
        $Expenses->documents = $imagePath;
    }

    $Expenses->save();

    return response()->json([
        'success' => true,
        'message' => 'Expenses saved successfully',
        'Expenses' => $Expenses,
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
        $validatedData = $request->all();

        $Expenses = Expenses::findOrFail($id);

        $Expenses->exp_head_id = $validatedData['exp_head_id'];
        $Expenses->name = $validatedData['name'];
        $Expenses->invoice_no = $validatedData['invoice_no'];
        $Expenses->date = $validatedData['date'];
        $Expenses->amount = $validatedData['amount'];
        $Expenses->note = $validatedData['note'];
        $Expenses->documents = $validatedData['documents'] ?? null;

        // Handle file upload
        if ($request->hasFile('documents')) {
            $file = $request->file('documents');
            $imageName = 'expense_' . time() . '.' . $file->getClientOriginalExtension();
            $imageSubfolder = 'school_expense';
            $full_path = 1;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $Expenses->documents = $imagePath;
        }

        $Expenses->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Expenses' => $Expenses,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the Expenses by ID
            $Expenses = Expenses::findOrFail($id);

            // Delete the Expenses
            $Expenses->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Expenses  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the Expenses was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
