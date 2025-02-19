<?php

namespace App\Http\Controllers;


use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
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

        if($request->type){
            $days = $request->type;

            $endDate = now(); // Current date and time
            $startDate = now()->subDays($days); // Calculate the date N days ago

            $startDateFormatted = $startDate->format('Y-m-d');


            $endDateFormatted = $endDate->format('Y-m-d');

            $data = Income::leftJoin('income_head', 'income.inc_head_id', '=', 'income_head.id')
                            ->whereBetween('income.date', [$startDateFormatted, $endDateFormatted])
                            ->orderBy('income.id', 'desc')
                            ->get();

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        }


        if($request->selectedStartDate && $request->selectedEndDate){
            
            $startDateFormatted = $request->selectedStartDate;

            $endDateFormatted = $request->selectedEndDate;

            $data = Income::leftJoin('income_head', 'income.inc_head_id', '=', 'income_head.id')
                            ->whereBetween('income.date', [$startDateFormatted, $endDateFormatted])
                            ->orderBy('income.id', 'desc')
                            ->get();

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        }

        // Paginate the students data
        $data = Income::leftJoin('income_head', 'income.inc_head_id', '=', 'income_head.id')
            ->orderBy('income.id', 'desc')
            ->paginate($perPage, ['income.*', 'income_head.income_category as 	income_category'], 'page', $page);
        // Prepare the response message
        $message = '';
        // Prepare the response message

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


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new Income
        $Income = new Income();
        $Income->inc_head_id = $validatedData['inc_head_id'];
        $Income->name = $validatedData['name'];
        $Income->invoice_no = $validatedData['invoice_no'];
        $Income->date = $validatedData['date'];
        $Income->amount = $validatedData['amount'];
        $Income->note = $validatedData['note'];


        if ($request->hasFile('documents')) {
            $file = $request->file('documents');
            $imageName = 'expense_' . time() . '.' . $file->getClientOriginalExtension(); // Example name
            $imageSubfolder = 'school_expense'; // Example subfolder
            $full_path = 1; // Flag for full path usage
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path); // Custom uploadImage function
            $Income->documents = $imagePath;
        }

        $Income->save();

        return response()->json([
            'success' => true,
            'message' => 'Income  saved successfully',
            'Income' => $Income,
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
        // Find the Income by id
        $validatedData = $request->all();

        $Income = Income::findOrFail($id);

        $Income->inc_head_id = $validatedData['inc_head_id'];
        $Income->name = $validatedData['name'];
        $Income->invoice_no = $validatedData['invoice_no'];
        $Income->date = $validatedData['date'];
        $Income->amount = $validatedData['amount'];
        $Income->note = $validatedData['note'];

        if ($request->hasFile('documents')) {
            $file = $request->file('documents');
            $imageName = 'expense_' . time() . '.' . $file->getClientOriginalExtension();
            $imageSubfolder = 'school_expense';
            $full_path = 1;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $Income->documents = $imagePath;
        }

        $Income->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Income' => $Income,
        ], 200); // 200 OK status code
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the Income by ID
            $Income = Income::findOrFail($id);

            // Delete the Income
            $Income->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Income  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the Income was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
