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
        'title' => 'required|string|max:255',
        'publish_date' => 'required|date',
        'date' => 'required|date',
        'message' => 'required|string',
    ]);



    // Create a new SendNotification
    $notification = new SendNotification();


    $notification->name = $validatedData['title'];
    $notification->name = $validatedData['publish_date'];
    $notification->name = $validatedData['date'];
    $notification->name = $validatedData['message'];
    if($validatedData['message_to'] == 'student')
    {
        $notification->visible_student = 'Yes';

    }else if($validatedData['message_to'] == 'parent')
    {
        $notification->visible_staff ='Yes' ;


    }else if($validatedData['message_to'] == 'admin')
    {
        $notification->visible_parent =='Yes' ;
    }else{

    };

    $notification->name = $validatedData['created_by'];
    $notification->name = $validatedData['created_id'];
    $notification->name = $validatedData['is_active'];
    $notification->name = $validatedData['class_id'];
    $notification->name = $validatedData['secid'];


    $notification->save();


    $file = $request->file('path');
         if($file)
         {
            $imageName = $notification->id .'_notification_'. time(); // Example name
            $imageSubfolder = 'notification';    // Example subfolder
            $full_path = 1;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['path'] = $imagePath;
         }

         $notification = SendNotification::findOrFail($notification->id);

         $notification->update($validatedData);

    return response()->json([
        'status' => 200,
        'message' => 'Notification saved successfully',
        'notification' => $notification,
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
             'notification' => $notification,
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
