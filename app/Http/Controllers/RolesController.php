<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class RolesController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        // Paginate the students data
        $data = Roles::get();

        // Prepare the response message
        $message = '';

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], 200);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();

        // Check if the roles already exists in the roles model
        $existingroles = Roles::where('name', $validatedData['name'])->first();

        if ($existingroles) {
            return response()->json([
                'success' => false,
                'message' => 'already exists',
            ], 409); // 409 Conflict status code
        }






        // Create a new roles
        $roles = new Roles();
        $roles->name = $validatedData['name'];
        $roles->slug = $validatedData['slug'];
        $roles->is_active = $validatedData['is_active'];
        $roles->is_system = $validatedData['is_system'];
        $roles->is_superadmin = $validatedData['is_superadmin'];
        $roles->save();

        return response()->json([
            'success' => true,
            'message' => '== saved successfully',
            'roles' => $roles,
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

        // Find the roles by id
        $roles = Roles::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();

        // Update the roles
        $roles->update($validatedData);



        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'roles' => $roles,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the roles by ID
            $roles = Roles::findOrFail($id);

            // Delete the roles
            $roles->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'roles deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the roles was not found)
            return response()->json(['success' => false, 'message' => 'roles deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
