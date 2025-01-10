<?php

namespace App\Http\Controllers;

use App\Models\Onlineexam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineexamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page'); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // Ensure $perPage is a positive integer and set a reasonable maximum value if needed
        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; // Default value if invalid
        }

        // Paginate the students data

        if ($page) {
            $data = Onlineexam::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
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
        } else {
            $data = Onlineexam::orderBy('id', 'desc')->get();
            $message = '';

            // Return the paginated data with total count and pagination details
            return response()->json([
                'success' => true,
                'data' => $data, // Only return the current page data
            ], 200);
        }
        // Prepare the response message
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new Onlineexam
        $Onlineexam = new Onlineexam();
        $Onlineexam->exam = $validatedData['exam'];
        $Onlineexam->is_quiz = $validatedData['is_quiz'] ?? 0;
        $Onlineexam->attempt = $validatedData['attempt'];
        $Onlineexam->exam_from = $validatedData['exam_from'];
        $Onlineexam->exam_to = $validatedData['exam_to'];
        $Onlineexam->auto_publish_date = $validatedData['auto_publish_date'];
        $Onlineexam->duration = $validatedData['duration'];
        $Onlineexam->passing_percentage = $validatedData['passing_percentage'];
        $Onlineexam->description = $validatedData['description'];
        $Onlineexam->is_active = $validatedData['is_active'] ?? 0;
        $Onlineexam->publish_result = $validatedData['publish_result'] ?? 0;
        $Onlineexam->is_neg_marking = $validatedData['is_neg_marking'] ?? 0;
        $Onlineexam->is_marks_display = $validatedData['is_marks_display'] ?? 0;
        $Onlineexam->is_random_question = $validatedData['is_random_question'] ?? 0;
        $Onlineexam->publish_exam_notification = $validatedData['publish_exam_notification'] ?? 0;
        $Onlineexam->publish_result_notification = $validatedData['publish_result_notification'] ?? 0;


        $Onlineexam->save();

        return response()->json([
            'success' => true,
            'message' => 'Onlineexam  saved successfully',
            'Onlineexam' => $Onlineexam,
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
        // Find the Onlineexam by id
        $validatedData = $request->all();

        $Onlineexam = Onlineexam::findOrFail($id);

        $Onlineexam->exam = $validatedData['exam'];
        $Onlineexam->is_quiz = $validatedData['is_quiz'] ?? 0;
        $Onlineexam->attempt = $validatedData['attempt'];
        $Onlineexam->exam_from = $validatedData['exam_from'];
        $Onlineexam->exam_to = $validatedData['exam_to'];
        $Onlineexam->auto_publish_date = $validatedData['auto_publish_date'];
        $Onlineexam->duration = $validatedData['duration'];
        $Onlineexam->passing_percentage = $validatedData['passing_percentage'];
        $Onlineexam->description = $validatedData['description'];
        $Onlineexam->is_active = $validatedData['is_active'] ?? 0;
        $Onlineexam->publish_result = $validatedData['publish_result'] ?? 0;
        $Onlineexam->is_neg_marking = $validatedData['is_neg_marking'] ?? 0;
        $Onlineexam->is_marks_display = $validatedData['is_marks_display'] ?? 0;
        $Onlineexam->is_random_question = $validatedData['is_random_question'] ?? 0;
        $Onlineexam->publish_exam_notification = $validatedData['publish_exam_notification'] ?? 0;
        $Onlineexam->publish_result_notification = $validatedData['publish_result_notification'] ?? 0;

        $Onlineexam->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Onlineexam' => $Onlineexam,
        ], 200); // 200 OK status code
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the Onlineexam by ID
            $Onlineexam = Onlineexam::findOrFail($id);

            // Delete the Onlineexam
            $Onlineexam->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Onlineexam  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the Onlineexam was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
