<?php

namespace App\Http\Controllers;

use App\Models\SchSettings;
use App\Models\Sessions;
use Illuminate\Http\Request;

class SchSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SchSettings::first();

        $get_session_data = Sessions::where('id', $data->session_id)->first();

        $data = $data->toArray(); // Convert the Eloquent model to an array
        $data['session_year'] = $get_session_data->session; // Add the key-value pair

        return response()->json([
            'success' => true,
            'data' => $data, // Return the updated array
        ], 200);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $id = $request->id;

        // Find the category by id
        $settings = SchSettings::findOrFail($id);

        /* for image update */
        $file = $request->file('admin_logo');
        $imageName = 'admin_logo' . time(); // Example name

        $imageSubfolder = 'school_content/admin_logo';    // Example subfolder
        $full_path = 0;

        $imagePath = uploadImage($file, $imageName, $imageSubfolder , $full_path);

        $data = $request->all();
        $data['admin_logo'] = $imagePath;
        $settings->update($data);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'category' => $settings,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
