<?php

namespace App\Http\Controllers;

use App\Models\SchSettings;
use App\Models\Sessions;
use App\Models\Students;
use App\Models\StudentSession;
use App\Services\StudentBalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    protected $studentBalanceService;

     public function __construct(StudentBalanceService $studentBalanceService)
     {
         $this->studentBalanceService = $studentBalanceService;
     }

     public function index(Request $request, $id = null, $role = null)
     {
          // Get pagination inputs, default to page 1 and 10 records per page if not provided
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);

    // Role ID (replace or customize as per your logic)
    $role_id = 1;

    // Build the query
    $query = DB::table('students')
    ->select('students.*');


// Apply pagination
$paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

    // Return paginated data with total count and pagination details
    return response()->json([
        'success' => true,
        'data' => $paginatedData->items(), // Only return the current page data
        'current_page' => $paginatedData->currentPage(),
        'per_page' => $paginatedData->perPage(),
        'total' => $paginatedData->total(),
    ], 200);
     }


     public function searchNonPromotedStudents(Request $request,$promoted_session_id , $promoted_class_id, $promoted_section_id, $class_id, $section_id, $current_session)
     {
          // Get pagination inputs, default to page 1 and 10 records per page if not provided
    $page = (int) $request->input('page', 1);
    $perPage = (int) $request->input('perPage', 10);

    // Role ID (replace or customize as per your logic)
    $role_id = 1;

    // Build the query


    $query = DB::table('students')
    ->join('student_session', 'student_session.student_id', '=', 'students.id')
    ->join('classes', 'student_session.class_id', '=', 'classes.id')
    ->join('sections', 'student_session.section_id', '=', 'sections.id')
    ->leftJoin('categories', 'students.category_id', '=', 'categories.id')
    ->leftJoin(DB::raw("(SELECT * FROM student_session WHERE session_id = {$promoted_session_id} AND class_id = {$promoted_class_id} AND section_id = {$promoted_section_id}) AS promoted_students"), 'promoted_students.student_id', '=', 'students.id')
    ->where('student_session.session_id', '=', $current_session)
    ->where('students.is_active', '=', 'yes')
    ->where('student_session.class_id', '=', $class_id)
    ->where('student_session.section_id', '=', $section_id)
    ->whereNull('promoted_students.id')
    ->orderBy('students.id')
    ->select(
        'promoted_students.id as promoted_student_id',
        'classes.id as class_id',
        'student_session.id as student_session_id',
        'students.id',
        'classes.class',
        'sections.id as section_id',
        'sections.section',
        'students.admission_no',
        'students.roll_no',
        'students.admission_date',
        'students.firstname',
        'students.middlename',
        'students.lastname',
        'students.image',
        'students.mobileno',
        'students.email',
        'students.state',
        'students.city',
        'students.pincode',
        'students.religion',
        'students.dob',
        'students.current_address',
        'students.permanent_address',
        DB::raw("IFNULL(students.category_id, 0) as category_id"),
        DB::raw("IFNULL(categories.category, '') as category"),
        'students.adhar_no',
        'students.samagra_id',
        'students.bank_account_no',
        'students.bank_name',
        'students.ifsc_code',
        'students.guardian_name',
        'students.guardian_relation',
        'students.guardian_phone',
        'students.guardian_address',
        'students.is_active',
        'students.created_at',
        'students.updated_at',
        'students.father_name',
        'students.rte',
        'students.gender'
    );


// Apply pagination
$paginatedData = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

    // Return paginated data with total count and pagination details
    return response()->json([
        'success' => true,
        'data' => $paginatedData->items(), // Only return the current page data
        'current_page' => $paginatedData->currentPage(),
        'per_page' => $paginatedData->perPage(),
        'total' => $paginatedData->total(),
    ], 200);
     }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){


        // Validate the incoming request
        $validatedData = $request->all();


        $get_year = SchSettings::first();


        // Create a new category
        $student = new Students();


        $student->parent_id = $validatedData['parent_id'];
        $student->admission_no = $validatedData['admission_no'];
        $student->roll_no = $validatedData['roll_no'];
        $student->admission_date = $validatedData['admission_date'];
        $student->firstname = $validatedData['firstname'];
        $student->middlename = $validatedData['middlename'];
        $student->lastname = $validatedData['lastname'];
        $student->rte = $validatedData['rte'];
        $student->image = $validatedData['image'];
        $student->mobileno = $validatedData['mobileno'];
        $student->email = $validatedData['email'];
        $student->state = $validatedData['state'];
        $student->city = $validatedData['city'];
        $student->pincode = $validatedData['pincode'];
        $student->religion = $validatedData['religion'];
        $student->cast = $validatedData['cast'];
        $student->dob = $validatedData['dob'];
        $student->gender = $validatedData['gender'];
        $student->current_address = $validatedData['current_address'];
        $student->permanent_address = $validatedData['permanent_address'];
        $student->category_id = $validatedData['category_id'];
        $student->route_id = $validatedData['route_id'];
        $student->school_house_id = $validatedData['school_house_id'];
        $student->blood_group = $validatedData['blood_group'];
        $student->vehroute_id = $validatedData['vehroute_id'];
        $student->hostel_room_id = $validatedData['hostel_room_id'];
        $student->adhar_no = $validatedData['adhar_no'];
        $student->samagra_id = $validatedData['samagra_id'];
        $student->bank_account_no = $validatedData['bank_account_no'];
        $student->bank_name = $validatedData['bank_name'];
        $student->ifsc_code = $validatedData['ifsc_code'];
        $student->guardian_is = $validatedData['guardian_is'];
        $student->father_name = $validatedData['father_name'];
        $student->father_phone = $validatedData['father_phone'];
        $student->father_occupation = $validatedData['father_occupation'];
        $student->mother_name = $validatedData['mother_name'];
        $student->mother_phone = $validatedData['mother_phone'];
        $student->mother_occupation = $validatedData['mother_occupation'];
        $student->guardian_name = $validatedData['guardian_name'];
        $student->guardian_relation = $validatedData['guardian_relation'];
        $student->guardian_phone = $validatedData['guardian_phone'];
        $student->guardian_occupation = $validatedData['guardian_occupation'];
        $student->guardian_address = $validatedData['guardian_address'];
        $student->guardian_email = $validatedData['guardian_email'];
        $student->father_pic = $validatedData['father_pic'];
        $student->mother_pic = $validatedData['mother_pic'];
        $student->guardian_pic = $validatedData['guardian_pic'];
        $student->is_active = $validatedData['is_active'];
        $student->previous_school = $validatedData['previous_school'];
        $student->height = $validatedData['height'];
        $student->weight = $validatedData['weight'];
        $student->measurement_date = $validatedData['measurement_date'];
        $student->dis_reason = $validatedData['dis_reason'];
        $student->note = $validatedData['note'];
        $student->dis_note = $validatedData['dis_note'];
        $student->app_key = $validatedData['app_key'];
        $student->parent_app_key = $validatedData['parent_app_key'];
        $student->disable_at = $validatedData['disable_at'];


        $student->save();

        $newdata = array(
            'student_id' => $student->id,
            'section_id' => $validatedData['section_id'],
            'session_id' => $get_year->session_id,
            'class_id' => $validatedData['class_id'],
            'route_id' => $validatedData['route_id'] ?? 0,
            'hostel_room_id' => $validatedData['hostel_room_id'] ?? 0,
            'vehroute_id' => $validatedData['vehroute_id'] ?? 0,
            'is_alumni' => 0,
        );



         $student = Students::findOrFail($student->id);

            /* image  */

         $file = $request->file('image');
         if($file)
         {
            $imageName = $student->id .'_student_images_'. time(); // Example name
            $imageSubfolder = 'student_images';    // Example subfolder
            $full_path = 1;
            $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
            $validatedData['image'] = $imagePath;
         }


         $file = $request->file('guardian_pic');
         if($file)
         {
         $imageName =  $student->id .'_guardian_pic_' . time(); // Example name
         $imageSubfolder = 'student_images';    // Example subfolder
         $full_path = 1;
         $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
         $validatedData['guardian_pic'] = $imagePath;
         }

         $file = $request->file('father_pic');
         if($file)
         {
         $imageName =  $student->id .'_father_pic_' . time(); // Example name
         $imageSubfolder = 'student_images';    // Example subfolder
         $full_path = 1;
         $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
         $validatedData['father_pic'] = $imagePath;
         }
         if($file)
         {
         $file = $request->file('mother_pic');
         $imageName =  $student->id .'_mother_pic_' . time(); // Example name
         $imageSubfolder = 'student_images';    // Example subfolder
         $full_path = 1;
         $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
         $validatedData['mother_pic'] = $imagePath;
         }

         /* image end */

          $student->update($validatedData);

        StudentSession::create($newdata);

        return response()->json([
            'status' => 200,
            'message' => 'Student Added successfully',
            'student' => $student,
        ], 201); // 201 Created status code
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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

    public function showForm()
    {
        return view('upload-image');
    }
    public function storeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $imageName = 'profile_picture_' . time(); // Custom name
        $imageSubfolder = 'profile_pictures';    // Optional subfolder
        $file_path = 1;

        // Use the helper to upload the file
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $file_path);

        if ($imagePath) {
            return response()->json([
                'message' => 'Image uploaded successfully!',
                'path' => $imagePath,
                'url' => asset("uploads/{$imagePath}"),
            ]);
        }

        return response()->json(['error' => 'Failed to upload image'], 500);
    }

    public function update(Request $request)
    {
        $id = $request->id;

        // Find the category by id
        $student = Students::findOrFail($id);


        $data = $request->all();

        $file = $request->file('image');
        if($file)
        {
        $imageName = $id .'_student_images_'. time(); // Example name
        $imageSubfolder = 'student_images';    // Example subfolder
        $full_path = 1;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $data['image'] = $imagePath;

        }


        $file = $request->file('guardian_pic');
        if($file)
        {
        $imageName =  $id .'_guardian_pic_' . time(); // Example name
        $imageSubfolder = 'student_images';    // Example subfolder
        $full_path = 1;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $data['guardian_pic'] = $imagePath;
        }

        $file = $request->file('father_pic');
        if($file)
        {
        $imageName =  $id .'_father_pic_' . time(); // Example name
        $imageSubfolder = 'student_images';    // Example subfolder
        $full_path = 1;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $data['father_pic'] = $imagePath;
        }

        $file = $request->file('mother_pic');
        if($file)
        {
        $imageName =  $id .'_mother_pic_' . time(); // Example name
        $imageSubfolder = 'student_images';    // Example subfolder
        $full_path = 1;
        $imagePath = uploadImage($file, $imageName, $imageSubfolder, $full_path);
        $data['mother_pic'] = $imagePath;
        }


        $student->update($data);

        $studentsession = StudentSession::where('student_id',$id)->first();
        $newdata = array(
            'student_id' => $id,
            'section_id' => $request->section_id,

            'class_id' => $request->class_id,
            'route_id' => $request->route_id ?? 0,
            'hostel_room_id' => $request->hostel_room_id ?? 0,
            'vehroute_id' => $request->vehroute_id ?? 0,
            'is_alumni' => 0,
        );

        $studentsession->update($newdata);

        return response()->json([
            'success' => true,
            'message' => 'Edit successfully',
            'category' => $student,
        ], 201); // 201 Created status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the category by ID
            $category = Students::findOrFail($id);

            // Delete the category
            $category->delete();

            // Return success response
            return response()->json(['success' => true, 'message' => 'Students  deleted successfully']);
        } catch (\Exception $e) {
            // Handle failure (e.g. if the category was not found)
            return response()->json(['success' => false, 'message' => 'Leave type deletion failed: ' . $e->getMessage()], 500);
        }
    }




    public function calculateBalances(Request $request)
    {
        $students = Students::get(); // Assuming students is passed as JSON
        $balanceGroup = '48';

        $studentsWithBalances = $this->studentBalanceService->calculateBalances(collect($students), $balanceGroup);

        return response()->json($studentsWithBalances);
    }
}
