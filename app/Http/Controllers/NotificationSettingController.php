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
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();


        // Create a new category
        $category = new SendNotification();
        $category->title = $validatedData['title'];
        $category->publish_date = $validatedData['publish_date'];
        $category->date = $validatedData['date'];
        $category->message = $validatedData['message'];
        $category->visible_student = $validatedData['visible_student'];
        $category->visible_staff = $validatedData['visible_staff'];
        $category->visible_parent = $validatedData['visible_parent'];
        $category->created_by = $validatedData['created_by'];
        $category->created_id = $validatedData['created_id'];
        $category->is_active = $validatedData['is_active'];
        $category->path = $validatedData['path'];
        $category->class_id = $validatedData['class_id'];
        $category->secid = $validatedData['secid'];
        $category->send_notification_id = $validatedData['send_notification_id'];
        $category->roles = $validatedData['roles'];

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Leave Type saved successfully',
            'category' => $category,
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

        // Find the category by id
        $category = SendNotification::findOrFail($id);

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
            $category = SendNotification::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Notification  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
