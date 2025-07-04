<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\FrontCmsPrograms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('perPage', 10);

        if ($perPage <= 0 || $perPage > 100) {
            $perPage = 10;
        }

        $message = 'Events retrieved successfully';

        if (!$request->has('page')) {
            $data = DB::table('front_cms_programs')->orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $data,
                'totalCount' => $data->count(),
                'rowsPerPage' => 1,
                'currentPage' => 1,
                'message' => $message,
            ], 200);
        }

        // Get total count
        $totalCount = DB::table('front_cms_programs')->count();

        // Get paginated data
        $data = DB::table('front_cms_programs')
            ->orderBy('id', 'desc')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'totalCount' => $totalCount,
            'rowsPerPage' => $perPage,
            'currentPage' => $page,
            'message' => $message,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->all();

        $Events = new FrontCmsPrograms();
        $Events->title = $validatedData['title'];
        $Events->description = $validatedData['meta_description'];
        $Events->meta_title = $validatedData['meta_title'];
        $Events->meta_keyword = $validatedData['meta_keywords'];
        $Events->event_start = $validatedData['event_type'];
        $Events->event_end = $validatedData['event_color'];
        $Events->event_venue = $validatedData['venue'];
        $Events->feature_image = $validatedData['role_id'];
        $Events->sidebar = $validatedData['is_active'];
        $Events->type = $validatedData['is_active'];
        $Events->meta_description = $validatedData['meta_description'];




        $Events->save();

        return response()->json([
            'success' => true,
            'message' => 'Events saved successfully',
            'Events' => $Events,
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

        $Events = FrontCmsPrograms::findOrFail($id);
        $Events->title = $validatedData['title'];
        $Events->description = $validatedData['meta_description'];
        $Events->meta_title = $validatedData['meta_title'];
        $Events->meta_keyword = $validatedData['meta_keywords'];
        $Events->event_start = $validatedData['event_type'];
        $Events->event_end = $validatedData['event_color'];
        $Events->event_venue = $validatedData['venue'];
        $Events->feature_image = $validatedData['role_id'];
        $Events->sidebar = $validatedData['is_active'];
        $Events->type = $validatedData['is_active'];
        $Events->meta_description = $validatedData['meta_description'];


        $Events->update();

        return response()->json([

            'success' => true,
            'message' => 'Edit successfully',
            'Events' => $Events,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $Events = FrontCmsPrograms::findOrFail($id);

            $Events->delete();

            return response()->json(['success' => true, 'message' => 'Events Category  deleted successfully']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
