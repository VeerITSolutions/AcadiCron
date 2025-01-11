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


        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);


         $query =  FeesReminder::select('*');


        // Apply pagination
        $paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);



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
    public function create(Request $request)
    {
        // Decode and validate the incoming request data
        $validatedData = json_decode($request->getContent(), true);

        if (!is_array($validatedData)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data format',
            ], 400); // Bad Request
        }

        $failedUpdates = [];
        $successUpdates = [];

        foreach ($validatedData as $value) {
            // Ensure required fields are present
            if (!isset($value['id'], $value['reminder_type'], $value['day'], $value['is_active'])) {
                $failedUpdates[] = [
                    'id' => $value['id'] ?? null,
                    'error' => 'Missing required fields',
                ];
                continue;
            }

            // Find the FeesReminder record by ID
            $feesreminder = FeesReminder::find($value['id']);

            if ($feesreminder) {
                try {
                    // Update the record with the new data
                    $feesreminder->reminder_type = $value['reminder_type'];
                    $feesreminder->day = $value['day'];
                    $feesreminder->is_active = $value['is_active'];

                    // Save the changes
                    $feesreminder->save();
                    $successUpdates[] = $value['id'];
                } catch (\Exception $e) {
                    $failedUpdates[] = [
                        'id' => $value['id'],
                        'error' => $e->getMessage(),
                    ];
                }
            } else {
                $failedUpdates[] = [
                    'id' => $value['id'],
                    'error' => 'Record not found',
                ];
            }
        }

        // Prepare the response
        $response = [
            'success' => count($successUpdates) > 0,
            'message' => count($failedUpdates) > 0
                ? 'Some updates failed'
                : 'All records updated successfully',
            'updated_ids' => $successUpdates,
            'failed_updates' => $failedUpdates,
        ];

        return response()->json($response, 200);
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
