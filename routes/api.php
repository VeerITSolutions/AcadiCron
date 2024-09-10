<?php

use Illuminate\Http\Request;




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
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NotificationRolesController;
use App\Http\Controllers\OnlineexamStudentsController;
use App\Http\Controllers\SchoolHousesController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentAttendencesController;
use App\Http\Controllers\TimetablesController;
use App\Models\FeeSessionGroups;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\StudentListController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ClassSectionsController;
use App\Http\Controllers\ContentForController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FeeSessionGroupsController;
use App\Http\Controllers\LeaveTypesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\StaffLeaveRequestController;
use App\Http\Controllers\StaffPayrollController;
use App\Http\Controllers\SubjectsController;

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


/* Route::get('/', [SiteController::class, 'showLoginForm'])->name('login');
Route::post('/login', [SiteController::class, 'login']); */


Route::get('/register', [SiteController::class, 'showRegistrationForm']);
Route::post('/register', [SiteController::class, 'register'])->name('register');

Route::get('/', [SiteController::class, 'showLoginForm'])->name('main');
Route::post('/login', [SiteController::class, 'login'])->name('login');

/* Route::middleware(['auth:staff', 'staff'])->group(function () { */
    Route::get('administrator/dashboard', [SiteController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/income', [IncomeController::class, 'adminIncome']);



        Route::get('/admin/expense', [IncomeController::class, 'adminExpense']);



        Route::get('/admin/dtstudentlist', [StudentListController::class, 'searchdtByClassSection']);

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

        Route::get('/category', [CategoriesController::class, 'index']);
        Route::post('/category', [CategoriesController::class, 'create']);
        Route::delete('/category/{id}', [CategoriesController::class, 'destroy']);
        Route::put('/category/{id}', [CategoriesController::class, 'update']);


        Route::get('/schoolhouse', [SchoolHousesController::class, 'index']);
        Route::post('/schoolhouse', [SchoolHousesController::class, 'create']);
        Route::delete('/schoolhouse/{id}', [SchoolHousesController::class, 'destroy']);
        Route::put('/schoolhouse/{id}', [SchoolHousesController::class, 'update']);


        Route::get('/fees-master', [FeemastersController::class, 'index']);
        Route::post('/fees-master', [FeemastersController::class, 'create']);
        Route::delete('/fees-master/{id}', [FeemastersController::class, 'destroy']);
        Route::put('/fees-master/{id}', [FeemastersController::class, 'update']);


        Route::get('/fees-group', [FeeGroupsController::class, 'index']);
        Route::post('/fees-group', [FeeGroupsController::class, 'create']);
        Route::delete('/fees-group/{id}', [FeeGroupsController::class, 'destroy']);
        Route::put('/fees-group/{id}', [FeeGroupsController::class, 'update']);


        Route::get('/fees-type', [FeetypeController::class, 'index']);
        Route::post('/fees-type', [FeetypeController::class, 'create']);
        Route::delete('/fees-type/{id}', [FeetypeController::class, 'destroy']);
        Route::put('/fees-type/{id}', [FeetypeController::class, 'update']);

        Route::get('/fees-session-group', [FeeSessionGroupsController::class, 'index']);
        Route::post('/fees-session-group', [FeeSessionGroupsController::class, 'create']);
        Route::delete('/fees-session-group/{id}', [FeeSessionGroupsController::class, 'destroy']);
        Route::put('/fees-session-group/{id}', [FeeSessionGroupsController::class, 'update']);

        Route::get('/subjects', [SubjectsController::class, 'index']);
        Route::post('/subjects', [SubjectsController::class, 'create']);
        Route::delete('/subjects/{id}', [SubjectsController::class, 'destroy']);
        Route::put('/subjects/{id}', [SubjectsController::class, 'update']);

        Route::get('/class-sections', [ClassSectionsController::class, 'index']);
        Route::post('/class-sections', [ClassSectionsController::class, 'create']);
        Route::delete('/class-sections/{id}', [ClassSectionsController::class, 'destroy']);
        Route::put('/class-sections/{id}', [ClassSectionsController::class, 'update']);


        Route::get('/sections', [SectionsController::class, 'index']);
        Route::post('/sections', [SectionsController::class, 'create']);
        Route::delete('/sections/{id}', [SectionsController::class, 'destroy']);
        Route::put('/sections/{id}', [SectionsController::class, 'update']);

        Route::get('/department', [DepartmentController::class, 'index']);
        Route::post('/department', [DepartmentController::class, 'create']);
        Route::delete('/department/{id}', [DepartmentController::class, 'destroy']);
        Route::put('/department/{id}', [DepartmentController::class, 'update']);


        Route::get('/timetable', [TimetablesController::class, 'index']);


        Route::get('/staff-payroll', [StaffPayrollController::class, 'index']);


        Route::get('/leave-request', [StaffLeaveRequestController::class, 'index']);
        Route::post('/leave-request', [StaffLeaveRequestController::class, 'create']);
        Route::delete('/leave-request/{id}', [StaffLeaveRequestController::class, 'destroy']);
        Route::put('/leave-request/{id}', [StaffLeaveRequestController::class, 'update']);

        Route::get('/leave-type', [LeaveTypesController::class, 'index']);
        Route::post('/leave-type', [LeaveTypesController::class, 'create']);
        Route::delete('/leave-type/{id}', [LeaveTypesController::class, 'destroy']);
        Route::put('/leave-type/{id}', [LeaveTypesController::class, 'update']);



        Route::get('/content-for-upload', [ContentForController::class, 'index']);
        Route::post('/content-for-upload', [ContentForController::class, 'create']);
        Route::delete('/content-for-upload/{id}', [ContentForController::class, 'destroy']);
        Route::put('/content-for-upload/{id}', [ContentForController::class, 'update']);


        Route::get('/studentfee/searchpayment', [SiteController::class, 'studentFeeSearchPayment']);
        Route::get('/studentfee/feesearch', [SiteController::class, 'studentFeeSearch']);
        Route::get('/classes', [SiteController::class, 'classes']);
       /*  Route::get('/sections', [SiteController::class, 'sections']); */
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





Route::get('site/logout', [SiteController::class, 'logout'])->name('admin.logout');
