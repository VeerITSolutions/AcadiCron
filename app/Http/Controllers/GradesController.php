<?php

namespace App\Http\Controllers;

use App\Models\Grades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradesController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); 
        $perPage = $request->input('perPage', 10);

        $page = (int) $page;
        $perPage = (int) $perPage;

        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10; 
        }

        $data = Grades::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $message = '';

        return response()->json([
            'success' => true,
            'data' => $data->items(), 
            'totalCount' => $data->total(), 
            'rowsPerPage' => $data->lastPage(), 
            'currentPage' => $data->currentPage(),
            'message' => $message,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->all();
    
        $Grades = new Grades();
        $Grades->exam_type = $validatedData['exam_type'];
        $Grades->name = $validatedData['name'];
        $Grades->point = $validatedData['point'];
        $Grades->mark_from = $validatedData['mark_from'];
        $Grades->mark_upto = $validatedData['mark_upto'];
        $Grades->description = $validatedData['description'];
        $Grades->is_active = $validatedData['is_active'];
        

        $Grades->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Item Category saved successfully',
            'Grades' => $Grades,
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
        $validatedData = $request->all();

        $Grades = Grades::findOrFail($id);

        $Grades->exam_type = $validatedData['exam_type'];
        $Grades->name = $validatedData['name'];
        $Grades->point = $validatedData['point'];
        $Grades->mark_from = $validatedData['mark_from'];
        $Grades->mark_upto = $validatedData['mark_upto'];
        $Grades->description = $validatedData['description'];
        $Grades->is_active = $validatedData['is_active'];

    
        $Grades->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Grades' => $Grades,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $Grades = Grades::findOrFail($id);

            $Grades->delete();

            return response()->json(['success' => true, 'message' => 'Grades deleted successfully']);
        } catch (\Exception $e) {
        
            return response()->json(['success' => false, 'message' => 'Grades deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
