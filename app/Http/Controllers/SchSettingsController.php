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
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'currency' => 'required|string', 
            'timezone' => 'required|string',
         
        ]);
    
        $settings = new SchSettings();

        
        $settings->name = $validatedData['name'];
        $settings->email = $validatedData['email'];
        $settings->phone = $validatedData['phone'];
        $settings->currency = $validatedData['currency'];
        $settings->timezone = $validatedData['timezone'];
        $settings->address = $validatedData['address'] ?? '';
        $settings->languages = $validatedData['languages'] ?? '[]';
        $settings->time_format = $validatedData['time_format'] ?? '12-hour';
        $settings->currency_symbol = $validatedData['currency_symbol'] ?? '';
        $settings->my_question = $validatedData['my_question'] ?? '';
    
        $settings->save();

        return response()->json([
            'status' => 200,
            'message' => 'Settings added successfully',
            'settings' => $settings,
        ], 201);
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
        $file = $request->file('image');
        $imageName = 'profile_picture_' . time(); // Example name
        $imageSubfolder = 'profile_pictures';    // Example subfolder

        $imagePath = uploadImage($file, $imageName, $imageSubfolder);


        $settings->update($request->all());




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
