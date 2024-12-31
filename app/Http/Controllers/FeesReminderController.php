<?php

namespace App\Http\Controllers;

use App\Models\FeesReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeesReminderController extends Controller
{  /**
    * Display a listing of the resource.
    */

    public function index(Request $request, $id = null, $role = null)
    {

        $id = $request->input('id');
         // Get pagination inputs, default to page 1 and 10 records per page if not provided
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);

        // Role ID (replace or customize as per your logic)
        $role_id = 1;

        // Build the query


        $query = DB::table('fees_reminder')
        ->select(
            'fees_reminder.*'
        );


        // Apply pagination
        $paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        if (!empty($id)) {
            $query->where('students.id', $id);
            $student = $query->first(); // Fetch a single result without pagination

            return response()->json([
                'success' => true,
                'data' => $student,
            ], 200);
        }

        // Return paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $paginatedData->items(), // Only return the current page data
            'current_page' => $paginatedData->currentPage(),
            'per_page' => $paginatedData->perPage(),
            'total' => $paginatedData->total(),
        ], 200);
    }








   /**
    * Show the form for creating a new resource.
    */
   public function create(Request $request){

        // Validate the incoming request
        $validatedData = json_decode($request->getContent(), true);

        // Iterate over the array of fee reminders and update each record
        foreach ($validatedData as $value) {
            // Find the FeesReminder record by ID
            $feesreminder = FeesReminder::find($value['id']);


            if ($feesreminder) {
                // Update the record with the new data
                $feesreminder->reminder_type = $value['reminder_type'];
                $feesreminder->day = $value['day'];
                $feesreminder->is_active = $value['is_active'];

                // Save the changes
                $feesreminder->update();
            }
        }

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Updated successfully',
        ], 200); // Use 200 OK status code for successful updates
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

       // Find the category by id
       $category = FeesReminder::findOrFail($id);

       // Validate the request data
       $validatedData = $request->all();

       // Update the category
       $category->update($validatedData);




       return response()->json([
           'success' => true,
           'message' => 'Edit successfully',
           'category' => $category,
       ], 201); // 201 Created status code
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($id)
   {
       try {
           // Find the category by ID
           $category = FeesReminder::findOrFail($id);

           // Delete the category
           $category->delete();

           // Return success response
           return response()->json(['success' => true, 'message' => 'Fees Reminder deleted successfully']);
       } catch (\Exception $e) {
           // Handle failure (e.g. if the category was not found)
           return response()->json(['success' => false, 'message' => 'Fees Reminder  deletion failed: ' . $e->getMessage()], 500);
       }
   }
}
