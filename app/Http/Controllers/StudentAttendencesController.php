<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentAttendencesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // Retrieve the 'id' from the request if it exists
        $id = $request->input('id');
    
        // Start building the query on the student_attendences table
        $query = DB::table('student_attendences');
    
        // If an ID is provided, filter the results by ID
        if ($id !== null) {
            $query->where('id', $id);
        } else {
            // If no ID is provided, order the results by ID
            $query->orderBy('id');
        }
    
        // Execute the query and return the result
        return $id !== null ? $query->first() : $query->get();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
