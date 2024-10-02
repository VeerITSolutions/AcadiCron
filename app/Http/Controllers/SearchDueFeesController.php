<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchDueFeesController extends Controller
{
    /**
    * Display a listing of the resource.
    */

    public function getDueStudentFeesDefault($feegroup_id = null, $fee_groups_feetype_id = null, $class_id = null, $section_id = null)
    {
        $query = DB::table('students')
            ->join('student_session', 'student_session.student_id', '=', 'students.id')
            ->join('classes', 'student_session.class_id', '=', 'classes.id')
            ->join('sections', 'student_session.section_id', '=', 'sections.id')
            ->leftJoin('categories', 'students.category_id', '=', 'categories.id')
            ->leftJoin('student_fees_master', function($join) use ($feegroup_id) {
                $join->on('student_fees_master.student_session_id', '=', 'student_session.id');
                if (!is_null($feegroup_id)) {
                    $join->where('student_fees_master.fee_session_group_id', '=', $feegroup_id);
                }
            })
            ->leftJoin('student_fees_deposite', function($join) use ($fee_groups_feetype_id) {
                $join->on('student_fees_deposite.student_fees_master_id', '=', 'student_fees_master.id');
                if (!is_null($fee_groups_feetype_id)) {
                    $join->where('student_fees_deposite.fee_groups_feetype_id', '=', $fee_groups_feetype_id);
                }
            })
            ->join('fee_groups_feetype', 'fee_groups_feetype.id', '=', DB::raw($fee_groups_feetype_id ? $fee_groups_feetype_id : 'fee_groups_feetype.id'))
            ->where('student_session.session_id', '=', "2023-2024")
            ->where('students.is_active', '=', 'yes');
    
        // Handle conditional class and section filters
        if ($class_id) {
            $query->where('student_session.class_id', '=', $class_id);
        }
        if ($section_id) {
            $query->where('student_session.section_id', '=', $section_id);
        }
    
        // Order by students.id
        $query->orderBy('students.id');
    
        return $query->get()->toArray();
    }
    

    public function getDueFeeByStudent($class_id = null, $section_id = null, $student_id = null)
    {
        $query = DB::table('feemasters')
            ->leftJoin('student_fees', function ($join) use ($student_id, $class_id, $section_id) {
                $join->on('student_fees.feemaster_id', '=', 'feemasters.id')
                    ->join('student_session', 'student_fees.student_session_id', '=', 'student_session.id')
                    ->where('student_session.student_id', '=', $student_id)
                    ->where('student_session.class_id', '=', $class_id)
                    ->where('student_session.section_id', '=', $section_id);
            })
            ->join('feetype', 'feemasters.feetype_id', '=', 'feetype.id')
            ->join('feecategory', 'feetype.feecategory_id', '=', 'feecategory.id')
            ->select([
                'feemasters.id as feemastersid',
                'feemasters.amount',
                DB::raw('IFNULL(student_fees.id, "xxx") as invoiceno'),
                DB::raw('IFNULL(student_fees.amount_discount, "xxx") as discount'),
                DB::raw('IFNULL(student_fees.amount_fine, "xxx") as fine'),
                DB::raw('IFNULL(student_fees.payment_mode, "xxx") as payment_mode'),
                DB::raw('IFNULL(student_fees.date, "xxx") as date'),
                'feetype.type',
                'feecategory.category',
                'student_fees.description'
            ])
            ->where('feemasters.class_id', '=', $class_id)
            ->where('feemasters.session_id', '=', "2023-2024")
            ->get();

        return $query->toArray();
    }

    public function getFeesByClass($class_id = null, $section_id = null, $student_id = null)
    {
        $query = DB::table('feemasters')
            ->leftJoin('student_fees', function ($join) use ($student_id, $class_id, $section_id) {
                $join->on('student_fees.feemaster_id', '=', 'feemasters.id')
                    ->join('student_session', 'student_fees.student_session_id', '=', 'student_session.id')
                    ->where('student_session.student_id', '=', $student_id)
                    ->where('student_session.class_id', '=', $class_id)
                    ->where('student_session.section_id', '=', $section_id);
            })
            ->leftJoin('feetype', 'feemasters.feetype_id', '=', 'feetype.id')
            ->leftJoin('feecategory', 'feetype.feecategory_id', '=', 'feecategory.id')
            ->select([
                'feemasters.id as feemastersid',
                'feemasters.amount',
                DB::raw('IFNULL(student_fees.id, "xxx") as invoiceno'),
                DB::raw('IFNULL(student_fees.amount_discount, "xxx") as discount'),
                DB::raw('IFNULL(student_fees.amount_fine, "xxx") as fine'),
                DB::raw('IFNULL(student_fees.date, "xxx") as date'),
                'feetype.type',
                'feecategory.category'
            ])
            ->where('feemasters.class_id', '=', $class_id)
            ->where('feemasters.session_id', '=', "2023-2024")
            ->get();

        return $query->toArray();
    }

    public function getFeeBetweenDate($start_date, $end_date)
    {
        $query = DB::table('student_fees')
            ->join('student_session', 'student_session.id', '=', 'student_fees.student_session_id')
            ->join('feemasters', 'feemasters.id', '=', 'student_fees.feemaster_id')
            ->join('feetype', 'feetype.id', '=', 'feemasters.feetype_id')
            ->join('classes', 'student_session.class_id', '=', 'classes.id')
            ->join('sections', 'sections.id', '=', 'student_session.section_id')
            ->join('students', 'students.id', '=', 'student_session.student_id')
            ->select([
                'student_fees.date',
                'student_fees.id',
                'student_fees.amount',
                'student_fees.amount_discount',
                'student_fees.amount_fine',
                'student_fees.created_at',
                'students.rte',
                'classes.class',
                'sections.section',
                'students.firstname',
                'students.middlename',
                'students.lastname',
                'students.admission_no',
                'students.roll_no',
                'students.dob',
                'students.guardian_name',
                'feetype.type'
            ])
            ->whereBetween('student_fees.date', [$start_date, $end_date])
            ->where('student_session.session_id', '=', "2023-2024")
            ->orderBy('student_fees.id')
            ->get();

        return $query->toArray();
    }

    public function getStudentTotalFee($class_id, $student_session_id)
    {
        $query = DB::select(
            "SELECT a.totalfee, b.fee_deposit, b.payment_mode
            FROM (SELECT COALESCE(SUM(amount), 0) as totalfee FROM `feemasters` WHERE session_id = ? AND class_id = ?) as a,
                 (SELECT COALESCE(SUM(amount), 0) as fee_deposit, payment_mode FROM `student_fees` WHERE student_session_id = ?) as b",
            ["2023-2024", $class_id, $student_session_id]
        );

        return $query[0];
    }






   /**
    * Show the form for creating a new resource.
    */
   public function create(Request $request){


       // Validate the incoming request
       $validatedData = $request->all();


       // Create a new category
       $category = new FeesReminder();
       $category->reminder_type = $validatedData['reminder_type'];
       $category->day = $validatedData['day'];

       $category->is_active = 1;

       $category->save();

       return response()->json([
           'success' => true,
           'message' => 'Fees Reminder saved successfully',
           'category' => $category,
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
       $category = FeesReminder::findOrFail($id);

       // Validate the request data
       $validatedData = $request->all();

       // Update the category
       $category->update($validatedData);




       return response()->json([
           'success' => true,
           'message' => 'Edit successfully',
           'category' => $category,
       ], 201); // 201 Created status code
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy($id)
   {
       try {
           // Find the category by ID
           $category = FeesReminder::findOrFail($id);

           // Delete the category
           $category->delete();

           // Return success response
           return response()->json(['success' => true, 'message' => 'Fees Reminder deleted successfully']);
       } catch (\Exception $e) {
           // Handle failure (e.g. if the category was not found)
           return response()->json(['success' => false, 'message' => 'Fees Reminder  deletion failed: ' . $e->getMessage()], 500);
       }
   }
}
