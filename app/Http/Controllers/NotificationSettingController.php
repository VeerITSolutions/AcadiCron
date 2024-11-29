<?php

namespace App\Http\Controllers;

use App\Models\ContentFor;
use App\Models\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request, $id = null, $role = null)
     {
         $page = $request->input('page', 1); // Default to page 1 if not provided
         $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

         // Validate the inputs (optional)
         $page = (int) $page;
         $perPage = (int) $perPage;



        $role_id = 1;

        $query = DB::table('send_notification')
            ->leftJoin(
                DB::raw('(SELECT send_notification_id, GROUP_CONCAT(role_id) as roles FROM notification_roles GROUP BY send_notification_id) as notification_roles'),
                'notification_roles.send_notification_id',
                '=',
                'send_notification.id'
            );

        if (!is_null($id)) {
            $query->where('send_notification.id', $id);
        }

        $result = $query->get();

        if (!is_null($id)) {
            $get_data = $result->first();
        } else {
            $get_data = $result;
        }

         // Return paginated data with total count and pagination details
         return response()->json([
             'success' => true,
             'data' => $get_data, // Only return the current page data

         ], 200);
     }




    /**
     * Show the form for creating a new resource.
     */
   

    public function create(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'title' => 'required|string|max:50',
            'publish_date' => 'required|date',
            'date' => 'required|date',
            'message' => 'required|string',
            'message_to' => 'required|string|in:student,parent,admin',
            'created_by' => 'required|string|max:60',
            'created_id' => 'required|integer',
            'is_active' => 'required|string|in:yes,no',
            'class_id' => 'nullable|string|max:30',
            'secid' => 'nullable|string|max:30',
            'path' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048', // Example validation for the file
        ]);

        try {
            // Use DB transaction for atomicity
            DB::beginTransaction();

            // Create a new SendNotification instance
            $notification = new SendNotification();

            $notification->title = $validatedData['title'];
            $notification->publish_date = $validatedData['publish_date'];
            $notification->date = $validatedData['date'];
            $notification->message = $validatedData['message'];
            $notification->created_by = $validatedData['created_by'];
            $notification->created_id = $validatedData['created_id'];
            $notification->is_active = $validatedData['is_active'];
            $notification->class_id = $validatedData['class_id'] ?? null;
            $notification->secid = $validatedData['secid'] ?? null;

            // Determine visibility flags
            $visibilityMap = [
                'student' => ['visible_student' => 'Yes', 'visible_staff' => 'No', 'visible_parent' => 'No'],
                'parent' => ['visible_student' => 'No', 'visible_staff' => 'Yes', 'visible_parent' => 'No'],
                'admin' => ['visible_student' => 'No', 'visible_staff' => 'No', 'visible_parent' => 'Yes'],
            ];

            $visibility = $visibilityMap[$validatedData['message_to']] ?? [
                'visible_student' => 'No',
                'visible_staff' => 'No',
                'visible_parent' => 'No',
            ];

            $notification->visible_student = $visibility['visible_student'];
            $notification->visible_staff = $visibility['visible_staff'];
            $notification->visible_parent = $visibility['visible_parent'];

            // Save the notification
            $notification->save();

            // Handle file upload
            if ($request->hasFile('path')) {
                $file = $request->file('path');
                $imageName = $notification->id . '_notification_' . time(); // Example name
                $imageSubfolder = 'notification'; // Example subfolder
                $full_path = 1;
                $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
                $notification->path = $imagePath;
            }

            // Save updated data (if path was added)
            $notification->save();

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Notification saved successfully',
                'notification' => $notification,
            ], 201); // 201 Created status code
        } catch (\Exception $e) {
            // Rollback on error
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while saving the notification',
                'error' => $e->getMessage(),
            ], 500);
        }
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
         // Find the category by ID
         $notification = SendNotification::findOrFail($id);

         // Validate incoming data
         $validatedData = $request->validate([
             'title' => 'required|string|max:255',
             'message' => 'required|string',
         ]);

         // Update category with validated data
         $notification->update($validatedData);

         $file = $request->file('path');
         if($file)
         {
         $imageName = $id .'_notification_'. time(); // Example name
         $imageSubfolder = 'notification';    // Example subfolder
         $full_path = 1;
         $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
         $data['path'] = $imagePath;
         }

         return response()->json([
             'success' => true,
             'message' => 'Edited successfully',
             'category' => $category,
         ], 200); // Use 200 for successful updates
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $notification = SendNotification::findOrFail($id);
            $notification->delete();
            return response()->json(['success' => true, 'message' => 'Notification  deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Notification deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
