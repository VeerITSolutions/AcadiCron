<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustomFieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getCustomFields(Request $request)
{

   $belongsTo =  $request->belongsTo;
   $displayTable = $request->displayTable;
    // Start building the query
    $query = DB::table('custom_fields')
        ->where('belong_to', $belongsTo)
        ->orderBy('weight', 'asc');

    // Check if $displayTable is provided and not empty
    if (!empty($displayTable)) {
        $query->where('visible_on_table', $displayTable);
    }

    // Execute the query and return the results
    return $query->get();
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
