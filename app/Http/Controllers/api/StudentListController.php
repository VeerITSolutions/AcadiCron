<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StudentListController extends Controller
{
    public function searchdtByClassSection(Request $request)
    {
        // Retrieve the current page and records per page from the request, with default values
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $perPage = $request->input('perPage', 10); // Default to 10 records per page if not provided

        // Validate the inputs (optional)
        $page = (int) $page;
        $perPage = (int) $perPage;

        // You can also validate $perPage to ensure it’s within a reasonable range

        // Paginate the students data
        $data = Students::paginate($perPage, ['*'], 'page', $page);

        // Prepare the response message
        $message = '';

        // Return the paginated data
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], 200);
    }


}
