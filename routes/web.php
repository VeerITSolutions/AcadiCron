<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\DisableReasonController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ExamGroupsController;
use App\Http\Controllers\ExamResultsController;
use App\Http\Controllers\FeeGroupsController;
use App\Http\Controllers\FeemastersController;
use App\Http\Controllers\FeesDiscountsController;
use App\Http\Controllers\FeetypeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NotificationRolesController;
use App\Http\Controllers\OnlineexamStudentsController;
use App\Http\Controllers\SchoolHousesController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentAttendencesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TimetablesController;
use App\Models\FeeSessionGroups;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/upload-image', [StudentsController::class, 'showForm'])->name('upload.form');
Route::post('/upload-image', [StudentsController::class, 'storeImage'])->name('upload.image');

/* Route::get('/', [SiteController::class, 'showLoginForm'])->name('login');
Route::post('/login', [SiteController::class, 'login']); */


Route::get('/register', [SiteController::class, 'showRegistrationForm']);
Route::post('/register', [SiteController::class, 'register'])->name('register');

Route::get('/', [SiteController::class, 'showLoginForm'])->name('main');
Route::post('/login', [SiteController::class, 'login'])->name('login');
Route::get('/run-python', function () {
    // The Python script location
    $scriptPath = base_path('python_scripts/sum.py');

    // Arguments to pass to the script
    $num1 = 5;
    $num2 = 7;

    // Execute the Python script and capture the output
    $output = shell_exec("python $scriptPath $num1 $num2");

    // Return the output as a response
    return response()->json(['result' => $output]);
});
Route::middleware(['auth:staff', 'staff'])->group(function () {
    Route::get('administrator/dashboard', [SiteController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/income', [IncomeController::class, 'adminIncome']);



    Route::get('/admin/expense', [IncomeController::class, 'adminExpense']);

    Route::get('/admin/stuattendence', [StudentAttendencesController::class, 'adminStuAttendance']);

    Route::get('/admin/staffattendance', [StaffAttendanceController::class, 'adminStaffAttendance']);

    Route::get('/admin/staff', [StaffController::class, 'adminStaff']);

    Route::get('/admin/examgroup', [ExamGroupsController::class, 'adminExamGroup']);

    Route::get('/admin/examresult', [ExamResultsController::class, 'adminExamResult']);

    Route::get('/admin/timetable/create', [TimetablesController::class, 'adminCreateTimetable']);

    Route::get('/admin/enquiry', [EnquiryController::class, 'adminEnquiry']);

    Route::get('/admin/complaint', [ComplaintController::class, 'adminComplaint']);

    Route::get('/admin/content', [ContentsController::class, 'adminContent']);

    Route::get('/admin/itemstock', [ItemController::class, 'adminItemStock']);

    Route::get('/admin/notification', [NotificationRolesController::class, 'adminNotification']);

    Route::get('/admin/mailsms/compose', [ComplaintController::class, 'adminMailSmsCompose']);

    Route::get('/admin/onlinestudent', [OnlineexamStudentsController::class, 'adminOnlineStudent']);

    Route::get('/admin/schoolhouse', [SchoolHousesController::class, 'adminSchoolHouse']);

    Route::get('/admin/disable_reason', [DisableReasonController::class, 'adminDisableReason']);

    Route::get('/admin/feemaster', [FeemastersController::class, 'adminFeeMaster']);

    Route::get('/admin/feegroup', [FeeGroupsController::class, 'adminFeeGroup']);

    Route::get('/admin/feetype', [FeetypeController::class, 'adminFeeType']);

    Route::get('/admin/feediscount', [FeesDiscountsController::class, 'adminFeeDiscount']);

    Route::get('/admin/feesforward', [FeeSessionGroups::class, 'adminFeesForward']);

    Route::get('/admin/feereminder/setting', [SiteController::class, 'adminFeeReminderSetting']);

    Route::get('/admin/stuattendence/attendencereport', [SiteController::class, 'adminAttendanceReport']);

    Route::get('/admin/approve_leave', [SiteController::class, 'adminApproveLeave']);

    Route::get('/admin/syllabus', [SiteController::class, 'adminSyllabus']);

    Route::get('/admin/syllabus/status', [SiteController::class, 'adminSyllabusStatus']);

    Route::get('/admin/lessonplan/lesson', [SiteController::class, 'adminLessonPlanLesson']);

    Route::get('/admin/lessonplan/topic', [SiteController::class, 'adminLessonPlanTopic']);

    Route::get('/admin/timetable/classreport', [SiteController::class, 'adminTimetableClassReport']);

    Route::get('/admin/timetable/mytimetable', [SiteController::class, 'adminTimetableMyTimetable']);

    Route::get('/admin/teacher/assign_class_teacher', [SiteController::class, 'adminAssignClassTeacher']);

    Route::get('/admin/stdtransfer', [SiteController::class, 'adminStdTransfer']);

    Route::get('/admin/subjectgroup', [SiteController::class, 'adminSubjectGroup']);

    Route::get('/admin/subject', [SiteController::class, 'adminSubject']);

    Route::get('/admin/payroll', [SiteController::class, 'adminPayroll']);

    Route::get('/admin/leaverequest/leaverequest', [SiteController::class, 'adminLeaveRequest']);

    Route::get('/admin/staff/leaverequest', [SiteController::class, 'adminStaffLeaveRequest']);

    Route::get('/admin/leavetypes', [SiteController::class, 'adminLeaveTypes']);

    Route::get('/admin/staff/rating', [SiteController::class, 'adminStaffRating']);

    Route::get('/admin/department/department', [SiteController::class, 'adminDepartment']);

    Route::get('/admin/designation/designation', [SiteController::class, 'adminDesignation']);

    Route::get('/admin/staff/disablestafflist', [SiteController::class, 'adminDisableStaffList']);

    Route::get('/admin/notification', [SiteController::class, 'adminNotification']);

    Route::get('/admin/mailsms/compose', [SiteController::class, 'adminMailSmsCompose']);

    Route::get('/admin/mailsms/compose_sms', [SiteController::class, 'adminMailSmsComposeSms']);

    Route::get('/admin/mailsms/index', [SiteController::class, 'adminMailSmsIndex']);

    Route::get('/admin/content', [SiteController::class, 'adminContent']);

    Route::get('/admin/content/assignment', [SiteController::class, 'adminContentAssignment']);

    Route::get('/admin/content/studymaterial', [SiteController::class, 'adminContentStudyMaterial']);

    Route::get('/admin/content/syllabus', [SiteController::class, 'adminContentSyllabus']);

    Route::get('/admin/content/other', [SiteController::class, 'adminContentOther']);

    Route::get('/admin/certificate/', [SiteController::class, 'adminCertificate']);

    Route::get('/admin/generatecertificate/', [SiteController::class, 'adminGenerateCertificate']);

    Route::get('/admin/studentidcard/', [SiteController::class, 'adminStudentIdCard']);

    Route::get('/admin/generateidcard/search', [SiteController::class, 'adminGenerateIdCardSearch']);

    Route::get('/admin/staffidcard/', [SiteController::class, 'adminStaffIdCard']);

    Route::get('/admin/generatestaffidcard/', [SiteController::class, 'adminGenerateStaffIdCard']);

    Route::get('/admin/userlog', [SiteController::class, 'adminUserLog']);

    Route::get('/admin/audit', [SiteController::class, 'adminAudit']);

    Route::get('/admin/notification/setting', [SiteController::class, 'adminNotificationSetting']);

    Route::get('/admin/paymentsettings', [SiteController::class, 'adminPaymentSettings']);

    Route::get('/admin/print_headerfooter', [SiteController::class, 'adminPrintHeaderFooter']);

    Route::get('/admin/roles', [SiteController::class, 'adminRoles']);

    Route::get('/admin/admin/backup', [SiteController::class, 'adminBackup']);

    Route::get('/admin/language', [SiteController::class, 'adminLanguage']);

    Route::get('/admin/users', [SiteController::class, 'adminUsers']);

    Route::get('/admin/module', [SiteController::class, 'adminModule']);

    Route::get('/admin/customfield', [SiteController::class, 'adminCustomField']);

    Route::get('/admin/captcha', [SiteController::class, 'adminCaptcha']);

    Route::get('/admin/systemfield', [SiteController::class, 'adminSystemField']);

    Route::get('/admin/onlineadmission/admissionsetting', [SiteController::class, 'adminOnlineAdmissionSetting']);

    Route::get('/admin/admin/filetype', [SiteController::class, 'adminFileType']);

    Route::get('/admin/updater', [SiteController::class, 'adminUpdater']);



    Route::get('/student/search', [SiteController::class, 'studentSearch']);
    Route::get('/studentfee', [SiteController::class, 'studentFee']);
    Route::get('/student/create', [SiteController::class, 'studentCreate']);
    Route::get('/student/disablestudentslist', [SiteController::class, 'studentDisableStudentsList']);
    Route::get('/student/multiclass', [SiteController::class, 'studentMultiClass']);
    Route::get('/student/bulkdelete', [SiteController::class, 'studentBulkDelete']);
    Route::get('/category', [SiteController::class, 'category']);
    Route::get('/studentfee/searchpayment', [SiteController::class, 'studentFeeSearchPayment']);
    Route::get('/studentfee/feesearch', [SiteController::class, 'studentFeeSearch']);
    Route::get('/classes', [SiteController::class, 'classes']);
    Route::get('/sections', [SiteController::class, 'sections']);
    Route::get('/student/bulkmail', [SiteController::class, 'studentBulkMail']);
    Route::get('/homework', [SiteController::class, 'homework']);
    Route::get('/report/studentinformation', [SiteController::class, 'reportStudentInformation']);
    Route::get('/report/finance', [SiteController::class, 'reportFinance']);
    Route::get('/report/attendance', [SiteController::class, 'reportAttendance']);
    Route::get('/report/examinations', [SiteController::class, 'reportExaminations']);
    Route::get('/report/lesson_plan', [SiteController::class, 'reportLessonPlan']);
    Route::get('/report/staff_report', [SiteController::class, 'reportStaffReport']);
    Route::get('/schsettings', [SiteController::class, 'schSettings']);
    Route::get('/sessions', [SiteController::class, 'sessions']);
    Route::get('/smsconfig', [SiteController::class, 'smsConfig']);
    Route::get('/emailconfig', [SiteController::class, 'emailConfig']);
    Route::get('/student/profilesetting', [SiteController::class, 'studentProfileSetting']);
});
Route::get('get-image/{image_name}', function (Request $request) {

    if (isset($request->image_name)) {
        $image_name = $request->image_name;

        if (file_exists(public_path('uploads/' . $image_name))) {

            $pdfPath =  public_path('uploads/' . $image_name);

            return $pdfPath;
        }
    }
});


Route::get('site/logout', [SiteController::class, 'logout'])->name('admin.logout');
