<?php

namespace App\Http\Controllers;

use App\Models\FeeGroupsFeetype;
use App\Models\StudentFees;
use App\Models\StudentFeesMaster;
use App\Models\StudentSession;
use Illuminate\Http\Request; // Add this line
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class StudentFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id = null, $role = null)
    {
        $student_session_id = $request->id;


        $studentDueFees = $this->getStudentFees($student_session_id) ?? []; // Replace with actual query logic

        $studentDiscounts = $this->getStudentFeesDiscount($student_session_id) ?? [];; // Replace with actual query logic

        $currencySymbol = "₹"; // Replace with your currency symbol logic

        return response()->json([
            'student_due_fees' => $studentDueFees,
            'student_discount_fees' => $studentDiscounts,
            'totals' => [
                'amount' => 0, // Total amount
                'paid' => 0,   // Total paid
                'discount' => 0, // Total discount
                'fine' => 0,   // Total fine
                'balance' => 0 // Remaining balance
            ],
            'currency_symbol' => $currencySymbol
        ]);
    }

    public function getStudentFees($student_session_id)
    {
        // Fetch the student fees along with the fee group names
        $result = DB::table('student_fees_master')
            ->join('fee_session_groups', 'student_fees_master.fee_session_group_id', '=', 'fee_session_groups.id')
            ->join('fee_groups', 'fee_groups.id', '=', 'fee_session_groups.fee_groups_id')
            ->where('student_session_id', $student_session_id)
            ->select('student_fees_master.*', 'fee_groups.name')
            ->orderBy('student_fees_master.id')
            ->get();

        if ($result->isNotEmpty()) {
            foreach ($result as $result_value) {
                $fee_session_group_id = $result_value->fee_session_group_id;
                $student_fees_master_id = $result_value->id;

                // Assuming this is a method you have that will return the due fee
                $result_value->fees = $this->getDueFeeByFeeSessionGroup($fee_session_group_id, $student_fees_master_id);

                // Check if the fee is system related and update the amount
                if ($result_value->is_system != 0 && isset($result_value->fees[0])) {
                    $result_value->fees[0]->amount = $result_value->amount;
                }
            }
        }

        return $result;
    }

    public function getStudentFeesDiscount($student_session_id = null)
    {
        $result = DB::table('student_fees_discounts')
            ->join('fees_discounts', 'fees_discounts.id', '=', 'student_fees_discounts.fees_discount_id')
            ->where('student_fees_discounts.student_session_id', $student_session_id)
            ->select(
                'student_fees_discounts.id',
                'student_fees_discounts.student_session_id',
                'student_fees_discounts.status',
                'student_fees_discounts.payment_id',
                'student_fees_discounts.description as student_fees_discount_description',
                'student_fees_discounts.fees_discount_id',
                'fees_discounts.name',
                'fees_discounts.code',
                'fees_discounts.amount',
                'fees_discounts.description',
                'fees_discounts.session_id'
            )
            ->orderBy('student_fees_discounts.id')
            ->get();

        return $result->toArray(); // Return the result as an array
    }

    public function getDueFeeByFeeSessionGroup($fee_session_groups_id, $student_fees_master_id)
    {
        $result = DB::table('student_fees_master')
            ->join('fee_session_groups', 'fee_session_groups.id', '=', 'student_fees_master.fee_session_group_id')
            ->join('fee_groups_feetype', 'fee_groups_feetype.fee_session_group_id', '=', 'fee_session_groups.id')
            ->join('fee_groups', 'fee_groups.id', '=', 'fee_groups_feetype.fee_groups_id')
            ->join('feetype', 'feetype.id', '=', 'fee_groups_feetype.feetype_id')
            ->leftJoin('student_fees_deposite', function ($join) {
                $join->on('student_fees_deposite.student_fees_master_id', '=', 'student_fees_master.id')
                    ->on('student_fees_deposite.fee_groups_feetype_id', '=', 'fee_groups_feetype.id');
            })
            ->where('student_fees_master.fee_session_group_id', $fee_session_groups_id)
            ->where('student_fees_master.id', $student_fees_master_id)
            ->select(
                'student_fees_master.*',
                'fee_groups_feetype.id as fee_groups_feetype_id',
                'fee_groups_feetype.amount',
                'fee_groups_feetype.due_date',
                'fee_groups_feetype.fine_amount',
                'fee_groups_feetype.fee_groups_id',
                'fee_groups.name',
                'fee_groups_feetype.feetype_id',
                'feetype.code',
                'feetype.type',
                DB::raw('IFNULL(student_fees_deposite.id, 0) as student_fees_deposite_id'),
                DB::raw('IFNULL(student_fees_deposite.amount_detail, 0) as amount_detail')
            )
            ->orderBy('fee_groups_feetype.due_date', 'ASC')
            ->get();

        return $result;
    }


    public function getDueFeeByFeeSessionGroupFeetype(Request $request)
    {
        $fee_session_groups_id = $request->input('fee_session_groups_id');
        $student_fees_master_id = $request->input('student_fees_master_id');
        $fee_groups_feetype_id = $request->input('fee_groups_feetype_id');
        $payload = $request->input('payload');
        $deposits = $request->input('deposits');
        $student_details = $request->input('student_details');

        if (!is_array($payload)) {
            $payload = json_decode($payload, true);
        }

        // Handle single object payloads
        if (!isset($payload[0]) || !is_array($payload[0])) {
            $payload = [$payload];
        }

        if (!isset($deposits[0]) || !is_array($deposits[0])) {
            $deposits = [$deposits];
        }

        if (!isset($student_details[0]) || !is_array($student_details[0])) {
            $student_details = [$student_details];
        }

        $getdata = (new StudentFeesMaster())->getDueFeeByFeeSessionGroupFeetype(
            $fee_session_groups_id,
            $student_fees_master_id,
            $fee_groups_feetype_id
        );

        $html = view('admin.feemaster.feesprint', [
            'getdata' => $getdata,
            'fee_session_groups_id' => $fee_session_groups_id,
            'student_fees_master_id' => $student_fees_master_id,
            'fee_groups_feetype_id' => $fee_groups_feetype_id,
            'payload' => $payload,
            'deposits' => $deposits,
            'student_details' => $student_details,
        ])->render();

        return response()->json($html);
    }

    public function getRestoreFeeSessionGroupFeetype(Request $request)
    {
        $fees_id = $request->input('fees_id');
        $deposits_id = $request->input('deposits_id');

        $fees_model = new StudentFees();
        $result = $fees_model->remove($fees_id, $deposits_id);


        return response()->json(
            ['data' => $fees_id]
        );

        /*     return response()->json($html); */
    }

    public function addFeeGroup(Request $request)
    {
        // Manually build validation since Laravel can't validate row_counter[0] as 'array'
        $rowCounter = $request->input('row_counter');

        if (!is_array($rowCounter) || empty($rowCounter)) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => ['row_counter' => [__('fees_list')]],
            ], 422);
        }

        if (!$request->has('collected_date') || !strtotime($request->input('collected_date'))) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => ['collected_date' => [__('date')]],
            ], 422);
        }

        $admin = Session::get('admin');
        $collectedBy = " Collected By: " . ($admin['name'] ?? 'Admin');

        $sendTo           = $request->input('guardian_phone');
        $email            = $request->input('guardian_email');
        $parentAppKey     = $request->input('parent_app_key');
        $studentSessionId = $request->input('student_session_id');

        $collectedArray = [];

        foreach ($rowCounter as $rowId) {
            $jsonArray = [
                'amount'          => $request->input("fee_amount_$rowId"),
                'date'            => $request->input('collected_date'),
                'description'     => $request->input('fee_gupcollected_note') . $collectedBy,
                'amount_discount' => 0,
                'amount_fine'     => $request->input("fee_groups_feetype_fine_amount_$rowId"),
                'payment_mode'    => $request->input('payment_mode_fee'),
                'received_by'     => $admin['id'] ?? 0,
            ];

            $collectedArray[] = [
                'student_fees_master_id' => $request->input("student_fees_master_id_$rowId"),
                'fee_groups_feetype_id'  => $request->input("fee_groups_feetype_id_$rowId"),
                'amount_detail'          => $jsonArray,
            ];
        }

        // Process deposits
        $feesRecord = app(\App\Models\StudentFeesMaster::class)->feeDepositCollectionsCIStyle($collectedArray);

        // foreach ($rowCounter as $index => $rowId) {
        //     $feeGroup = app(\App\Models\FeeGroupsFeetype::class)
        //         ->getFeeGroupByID($request->input("fee_groups_feetype_id_$rowId"));

        //     $feeGroup->invoice         = json_encode($feesRecord[$index]);
        //     $feeGroup->contact_no      = $sendTo;
        //     $feeGroup->email           = $email;
        //     $feeGroup->parent_app_key  = $parentAppKey;

        //     app(\App\Models\MailSmsConf::class)->mailsms('fee_submission', $feeGroup);
        // }

        return response()->json(['status' => 1, 'error' => '']);
    }

    public function addFeeGroupStudentByFeeSessionGroup(Request $request)
    {
        $studentIds = $request->input('student_ids');
        $feeSessionGroupId = $request->input('fee_session_group_id');

        if (empty($studentIds) || !$feeSessionGroupId) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid data: Missing student_ids or fee_session_group_id'
            ], 422);
        }

        $collectedArray = [];
        $alreadyAssigned = [];

        foreach ($studentIds as $studentId) {
            // Check if the fee group is already assigned to the student
            $exists = DB::table('student_fees_master')
                ->where('student_session_id', $studentId)
                ->where('fee_session_group_id', $feeSessionGroupId)
                ->exists();

            if ($exists) {
                $alreadyAssigned[] = $studentId;
                continue;
            }

            $collectedArray[] = [
                'student_id'             => $studentId,
                'fee_session_group_id'   => $feeSessionGroupId,
                'student_fees_master_id' => 0, // assuming new record
            ];
        }

        // Insert only new entries
        foreach ($collectedArray as $item) {
            DB::table('student_fees_master')->insert([
                'student_session_id'    => $item['student_id'],
                'fee_session_group_id'  => $item['fee_session_group_id'],
                'amount'                => 0,
                'is_system'             => 0,
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Student fee records processed successfully.',
            'processed_count' => count($collectedArray),
            'already_assigned' => $alreadyAssigned, // optional info
        ]);
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
