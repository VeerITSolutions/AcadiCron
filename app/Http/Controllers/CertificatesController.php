<?php

namespace App\Http\Controllers;

use App\Models\Certificates;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificatesController extends Controller
{
      /**
     * Display a listing of the resource.
     */


public function index(Request $request, $id = null, $role = null)
{
    // Get pagination inputs, default to page 1 and 10 records per page if not provided
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);

    // Role ID (set this based on your application's needs)
    $role_id = 1;

    // Build the query to retrieve active certificates
    $query = DB::table('certificates')
        ->select('certificates.*')
        ->where('certificates.status', '=', 1);

    if(empty($page))
    {
         // Apply pagination to the query
    $paginatedData = $query->orderBy('id', 'desc')->get();
     // Return the response with paginated data
     return response()->json([
        'success' => true,
        'data' => $paginatedData
    ], 200);

    }else{
         // Apply pagination to the query
    $paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
     // Return the response with paginated data
     return response()->json([
        'success' => true,
        'data' => $paginatedData->items(), // Only return the current page data
        'current_page' => $paginatedData->currentPage(),
        'per_page' => $paginatedData->perPage(),
        'totalCount' => $paginatedData->total(),
    ], 200);

    }




}



public function certificateView(Request $request, string $id)
{



    // Ensure you actually use the `$id` value from the request
    if (!$id) {
        return response()->json(['error' => 'Invalid certificate ID'], 400);
    }

    // Retrieve the certificate record
    $certificate = DB::table('certificates')->where('id', $id)->first();

    if (!$certificate) {
        return response()->json(['error' => 'Certificate not found'], 404);
    }

    // Prepare data to pass to the view
    $data = [
        'certificate' => $certificate,
    ];
    $idsToGenerate = $request->idsToGenerate;
    if($idsToGenerate){

        $data['studentDatas']  = Students::whereIn('id', $idsToGenerate)->get();

    $preview = view('admin.certificate.generate_certificate', $data)->render();
    }else{
         // Render the preview view and return it as a response
    $preview = view('admin.certificate.preview_certificate', $data)->render();

    }


    return response()->json([
        'success' => true,
        'data' => $preview, // Return rendered HTML
    ], 200);
}



    /**
     * Show the form for creating a new resource.w
     */
    public function create(Request $request)
    {
        $certificate_name = $request->certificate_name;

        $validatedData = $request->all();

        // Check if the certificate already exists in the certificate model
        $existingcertificate = Certificates::where('certificate_name', $certificate_name)->first();

        if ($existingcertificate) {
            return response()->json([
                'success' => false,
                'message' => 'already exists',
            ], 409); // 409 Conflict status code
        }

        // Create a new certificate
        $certificate = new Certificates();

        $certificate->certificate_name = $validatedData['certificate_name'];
        $certificate->certificate_text = $validatedData['certificate_text'];
        $certificate->left_header = $validatedData['left_header'];
        $certificate->center_header = $validatedData['center_header'];
        $certificate->right_header = $validatedData['right_header'];
        $certificate->left_footer = $validatedData['left_footer'];
        $certificate->right_footer = $validatedData['right_footer'];
        $certificate->center_footer = $validatedData['center_footer'];
        $certificate->header_height = $validatedData['header_height'];
        $certificate->content_height = $validatedData['content_height'];
        $certificate->footer_height = $validatedData['footer_height'];
        $certificate->content_width = $validatedData['content_width'];
        $certificate->created_for = $validatedData['created_for'] ?? 1;
        $certificate->status = $validatedData['status'] ?? 1;

        if ($validatedData['enable_student_image'] == 1) {
            $enableimg = $validatedData['enable_student_image'];
            $imgHeight = $validatedData['enable_image_height'];
        } else {
            $enableimg = 0;
            $imgHeight = 0;
        }

        $certificate->enable_student_image = $enableimg;
        $certificate->enable_image_height = $imgHeight;

        $file = $request->file('background_image');
        if ($file) {
            $imageName = $certificate->staff_id . '_document_' . time(); // Example name
            $imageSubfolder = "/certificate/" . $certificate->staff_id; // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $certificate->background_image = $imagePath;
        } else {
            $certificate->background_image = ''; // Provide a default value if no image is uploaded
        }

        $certificate->save();

        return response()->json([
            'success' => true,
            'message' => 'saved successfully',
            'certificate' => $certificate,
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
        $certificate = Certificates::findOrFail($id);

        // Validate the request data
        $validatedData = $request->all();




         // Handle the file upload if provided
         if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $imageName = $certificate->staff_id . '_document_' . time(); // Example name
            $imageSubfolder = "/certificate/" . $certificate->staff_id; // Example subfolder
            $full_path = 0;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $certificate->background_image = $imagePath; // Save the file path to the document field

            $validatedData['background_image'] = $imagePath;

        }


        if ($request->enable_student_image == 'true') {


            $validatedData['enable_student_image'] = 1;
        } else {




            $validatedData['enable_student_image'] = 0;
        }




        // Update the certificate
        $certificate->update($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'certificate' => $certificate,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $certificate = Certificates::findOrFail($id);

            // Delete the certificate
            $certificate->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the certificate was not found)
            return response()->json(['success' => false, 'message' => ' deletion failed: ' . $e->getMessage()], 500);
        }
    }


    public function generateMultiple(Request $request)
    {
        $studentData = $request->input('data');
        $studentArray = json_decode($studentData);
        $certificateId = $request->input('certificate_id');
        $classId = $request->input('class_id');

        $results = [];
        $studentIds = [];
        $data = [];

        // Fetch school settings
        $data['sch_setting'] = DB::table('sch_settings')
            ->join('sessions', 'sessions.id', '=', 'sch_settings.session_id')
            ->join('languages', 'languages.id', '=', 'sch_settings.lang_id')
            ->select(
                'sch_settings.*',
                'sessions.session',
                'languages.language'
            )
            ->first();

        // Fetch certificate details
        $data['certificate'] = DB::table('certificates')->where('id', $certificateId)->first();

        foreach ($studentArray as $student) {
            $studentIds[] = $student->student_id;

            // Check if a TC certificate exists for the student
            $existingCertificate = DB::table('certificate_tc')
                ->where('student_id', $student->student_id)
                ->first();

            if (!$existingCertificate) {
                // Generate a new TC number
                $maxTcNo = DB::table('certificate_tc')->max('tc_no');
                $newTcNo = $maxTcNo ? $maxTcNo + 1 : 1;

                // Insert the new TC certificate
                DB::table('certificate_tc')->insert([
                    'student_id' => $student->student_id,
                    'tc_no' => $newTcNo,
                ]);
            }

            // Fetch updated TC certificate
            $certData = DB::table('certificate_tc')
                ->where('student_id', $student->student_id)
                ->first();

            $results[] = $certData;
        }

        // Fetch student details
        $data['students'] = DB::table('students')
            ->whereIn('id', $studentIds)
            ->get();

        // Append TC number and full name to each student
        foreach ($data['students'] as $student) {
            $tcCertificate = collect($results)->firstWhere('student_id', $student->id);
            $student->tc_no = $tcCertificate->tc_no ?? null;

            // Assuming a custom method exists to generate the full name
            $student->name ='Pranay';
        }

        // Render the certificate view
        $certificates = view('admin.certificate.generate_certificate', $data)->render();

        return response($certificates, 200)
        ->header('Content-Type', 'text/html');
    }

    private function getFullName($student)
    {
        $middleNameSetting = DB::table('sch_settings')->value('middlename');
        $lastNameSetting = DB::table('sch_settings')->value('lastname');

        return trim(sprintf(
            '%s %s %s',
            $student->firstname,
            $middleNameSetting ? $student->middlename : '',
            $lastNameSetting ? $student->lastname : ''
        ));
    }
}
