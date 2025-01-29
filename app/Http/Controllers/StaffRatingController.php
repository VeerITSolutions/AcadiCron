<?php

namespace App\Http\Controllers;

use App\Models\StaffRating;
use Illuminate\Http\Request;

class StaffRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;



        // Paginate the students data
        $data = StaffRating::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        // Prepare the response message
        $message = '';

        // Return the paginated data with total count and pagination details
        return response()->json([
            'success' => true,
            'data' => $data->items(), // Only return the current page data
            'totalCount' => $data->total(), // Total number of records
            'rowsPerPage' => $data->lastPage(), // Total number of pages
            'currentPage' => $data->currentPage(), // Current page
            'message' => $message,
        ], 200);
    }

    public function getRatedStaff(Request $request)
    {
        $userId = $request->input('user_id');
        $role = $request->input('role');
        $userRatedStaffList = StaffRating::where('user_id', $userId)->pluck('staff_id')->toArray();

        $data['user_ratedstafflist'] = $userRatedStaffList;

        if ($role == "student") {
            $ratingsByStudent = StaffRating::where('user_id', $userId)->where('role', 'student')->get();
            foreach ($ratingsByStudent as $rating) {
                $data['reviews'][$rating->staff_id] = $rating->rate;
            }
        } elseif ($role == "parent") {
            $allRatings = StaffRating::all();
            $data['rate_canview'] = 0;
            foreach ($allRatings as $rating) {
                if ($rating->total >= 3) {
                    $r = ($rating->rate / $rating->total);
                    $data['avg_rate'][$rating->staff_id] = $r;
                    $data['rate_canview'] = 1;
                } else {
                    $data['avg_rate'][$rating->staff_id] = 0;
                }
                $data['reviews'][$rating->staff_id] = $rating->total;
            }
        }



        return response()->json([
            'success' => true,
            'message' => 'saved successfully',
            'staffrating' => $data,
        ], 201); // 201 Created status code
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        // Validate the incoming request
        $validatedData = $request->all();


        $existingCategory = StaffRating::where('user_id', $validatedData['user_id'])->where('staff_id', $validatedData['staff_id'])->first();

        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Staff Rating  already exists',
            ], 409);
        }

        // Create a new category
        $staffrating = new StaffRating();

        $staffrating->staff_id = $validatedData['staff_id'];
        $staffrating->comment = $validatedData['comment'];
        $staffrating->rate = $validatedData['rate'];
        $staffrating->user_id = $validatedData['user_id'];
        $staffrating->role = $validatedData['role'];
        $staffrating->status = $validatedData['status'];
        $staffrating->entrydt = $validatedData['entrydt'];

        $staffrating->save();

        return response()->json([
            'success' => true,
            'message' => 'saved successfully',
            'staffrating' => $staffrating,
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

        // Find the Subjects_name by id
        $staffrating = StaffRating::findOrFail($id);

        // Validate only the fields you need to validate
        $validatedData = $request->all();

        $staffratingupdate['staff_id'] = $validatedData['staff_id'];
        $staffratingupdate['comment'] = $validatedData['comment'];
        $staffratingupdate['rate'] = $validatedData['rate'];
        $staffratingupdate['user_id'] = $validatedData['user_id'];
        $staffratingupdate['role'] = $validatedData['role'];
        $staffratingupdate['status'] = $validatedData['status'];
        $staffratingupdate['entrydt'] = $validatedData['entrydt'];

        $staffrating->update($staffratingupdate);




        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'staffrating' => $staffrating,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $category = StaffRating::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'deletion failed: ' . $e->getMessage()], 500);
        }
    }
}
