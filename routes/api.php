<?php

use Illuminate\Http\Request;




use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DisableReasonController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ExamGroupsController;
use App\Http\Controllers\ExamResultsController;
use App\Http\Controllers\FeeGroupsController;
use App\Http\Controllers\FeemastersController;
use App\Http\Controllers\FeesDiscountsController;
use App\Http\Controllers\FeetypeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ContentsController;
use App\Http\Controllers\NotificationRolesController;
use App\Http\Controllers\OnlineexamStudentsController;
use App\Http\Controllers\SchoolHousesController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentAttendencesController;
use App\Http\Controllers\TimetablesController;

use App\Http\Controllers\CustomFieldsController;

use App\Models\FeeSessionGroups;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\StudentListController;
use App\Http\Controllers\AttendenceTypeController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CertificatesController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassSectionsController;
use App\Http\Controllers\ClassTeacherController;
use App\Http\Controllers\ContentForController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffDesignationController;
use App\Http\Controllers\FeeSessionGroupsController;
use App\Http\Controllers\FeesReminderController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\LeaveTypesController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\ContentSectionController;
use App\Http\Controllers\ExamsController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\StaffLeaveRequestController;
use App\Http\Controllers\StaffPayrollController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\SearchPaymentController;
use App\Http\Controllers\SearchDueFeesController;
use App\Http\Controllers\LessonplanLessonController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\HostelRoomController;

use App\Http\Controllers\RoomTypesController;
use App\Http\Controllers\TransportRouteController;

use App\Http\Controllers\SchSettingsController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SubjectSyllabusController;
use App\Http\Controllers\SubjectGroupsController;
use App\Http\Controllers\StudentFeesController;
use App\Http\Controllers\StudentApplyleaveController;
use App\Http\Controllers\StudentDocController;
use App\Http\Controllers\StudentTimelineController;
use App\Http\Controllers\IncomeHeadController;
use App\Models\TransportRoute;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ExpenseHeadController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\VehicleRoutesController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemStockController;
use App\Http\Controllers\ItemStoreController;
use App\Http\Controllers\ItemSupplierController;
use App\Http\Controllers\ItemIssueController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\FrontCmsMenusController;
use App\Http\Controllers\AlumniEventsController;







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

/* Route::middleware(['auth:sanctum'])->group(function () { */
/* test */
Route::get('administrator/dashboard', [SiteController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/income', [IncomeController::class, 'adminIncome']);


Route::get('/schsetting', [SchSettingsController::class, 'index']);
Route::post('/schsetting', [SchSettingsController::class, 'create']);
Route::post('/schsetting/{id}', [SchSettingsController::class, 'update']);


Route::get('/session', [SessionsController::class, 'index']);






Route::get('/admin/expense', [IncomeController::class, 'adminExpense']);



Route::match(['get', 'post'], '/admin/dtstudentlist', [StudentListController::class, 'searchdtByClassSection']);
Route::post('/admin/deletestudentbulk', [StudentListController::class, 'studentBlukDelete']);

Route::get('/admin/dtstudentlist/disabled', [StudentListController::class, 'getdisableStudent']);

Route::get('/admin/stuattendence', [StudentAttendencesController::class, 'adminStuAttendance']);

Route::get('/admin/staffattendance', [StaffAttendanceController::class, 'adminStaffAttendance']);

Route::get('/admin/staff', [StaffController::class, 'adminStaff']);

Route::get('/admin/examgroup', [ExamGroupsController::class, 'adminExamGroup']);

Route::get('/admin/examresult', [ExamResultsController::class, 'adminExamResult']);

Route::get('/admin/timetable/create', [TimetablesController::class, 'adminCreateTimetable']);

Route::get('/admin/enquiry', [EnquiryController::class, 'adminEnquiry']);

Route::get('/admin/complaint', [ComplaintController::class, 'adminComplaint']);



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

/* api logic start  */



Route::get('/student/search', [SiteController::class, 'studentSearch']);
Route::get('/studentfee', [SiteController::class, 'studentFee']);
Route::get('/student/create', [SiteController::class, 'studentCreate']);
Route::get('/student/disablestudentslist', [SiteController::class, 'studentDisableStudentsList']);
Route::get('/student/multiclass', [SiteController::class, 'studentMultiClass']);
Route::get('/student/bulkdelete', [SiteController::class, 'studentBulkDelete']);

Route::get('/category', [CategoriesController::class, 'index']);
Route::post('/category', [CategoriesController::class, 'create']);
Route::delete('/category/{id}', [CategoriesController::class, 'destroy']);
Route::post('/category/{id}', [CategoriesController::class, 'update']);


Route::get('/schoolhouse', [SchoolHousesController::class, 'index']);
Route::post('/schoolhouse', [SchoolHousesController::class, 'create']);
Route::delete('/schoolhouse/{id}', [SchoolHousesController::class, 'destroy']);
Route::post('/schoolhouse/{id}', [SchoolHousesController::class, 'update']);


Route::get('/fees-master', [FeemastersController::class, 'index']);
Route::post('/fees-master', [FeemastersController::class, 'create']);
Route::delete('/fees-master/{id}', [FeemastersController::class, 'destroy']);
Route::post('/fees-master/{id}', [FeemastersController::class, 'update']);

Route::get('/role', [RolesController::class, 'index']);
Route::post('/role', [RolesController::class, 'create']);
Route::delete('/role/{id}', [RolesController::class, 'destroy']);
Route::post('/role/{id}', [RolesController::class, 'update']);


Route::get('/fees-group', [FeeGroupsController::class, 'index']);
Route::post('/fees-group', [FeeGroupsController::class, 'create']);
Route::delete('/fees-group/{id}', [FeeGroupsController::class, 'destroy']);
Route::post('/fees-group/{id}', [FeeGroupsController::class, 'update']);


Route::get('/fees-type', [FeetypeController::class, 'index']);
Route::post('/fees-type', [FeetypeController::class, 'create']);
Route::delete('/fees-type/{id}', [FeetypeController::class, 'destroy']);
Route::post('/fees-type/{id}', [FeetypeController::class, 'update']);

Route::get('/fees-discount', [FeesDiscountsController::class, 'index']);
Route::post('/fees-discount', [FeesDiscountsController::class, 'create']);
Route::delete('/fees-discount/{id}', [FeesDiscountsController::class, 'destroy']);
Route::post('/fees-discount/{id}', [FeesDiscountsController::class, 'update']);


Route::get('/fees-session-group', [FeeSessionGroupsController::class, 'index']);
Route::post('/fees-session-group', [FeeSessionGroupsController::class, 'create']);
Route::delete('/fees-session-group/{id}', [FeeSessionGroupsController::class, 'destroy']);
Route::post('/fees-session-group/{id}', [FeeSessionGroupsController::class, 'update']);

Route::get('/subjects', [SubjectsController::class, 'index']);
Route::post('/subjects', [SubjectsController::class, 'create']);
Route::delete('/subjects/{id}', [SubjectsController::class, 'destroy']);
Route::post('/subjects/{id}', [SubjectsController::class, 'update']);

Route::get('/class-sections', [ClassSectionsController::class, 'index']);
Route::post('/class-sections', [ClassSectionsController::class, 'create']);
Route::delete('/class-sections/{id}', [ClassSectionsController::class, 'destroy']);
Route::post('/class-sections/{id}', [ClassSectionsController::class, 'update']);


Route::get('/sections', [SectionsController::class, 'index']);
Route::post('/sections', [SectionsController::class, 'create']);
Route::delete('/sections/{id}', [SectionsController::class, 'destroy']);
Route::post('/sections/{id}', [SectionsController::class, 'update']);
Route::get('/sections-by-class', [SectionsController::class, 'sectionByClass']);

Route::get('/department', [DepartmentController::class, 'index']);
Route::post('/department', [DepartmentController::class, 'create']);
Route::delete('/department/{id}', [DepartmentController::class, 'destroy']);
Route::post('/department/{id}', [DepartmentController::class, 'update']);

Route::get('/designation', [StaffDesignationController::class, 'index']);
Route::post('/designation', [StaffDesignationController::class, 'create']);
Route::delete('/designation/{id}', [StaffDesignationController::class, 'destroy']);
Route::post('/designation/{id}', [StaffDesignationController::class, 'update']);

Route::get('/timetable', [TimetablesController::class, 'index']);
Route::get('/timetable-by/{class_id?}/{section_id?}/{group_id?}/{day_id?}', [TimetablesController::class, 'getBySubjectGroupDayClassSection']);

Route::post('/timetable', [TimetablesController::class, 'create']);
Route::delete('/timetable/{id}', [TimetablesController::class, 'destroy']);
Route::post('/timetable/{id}', [TimetablesController::class, 'update']);



Route::get('/staff-payroll', [StaffPayrollController::class, 'index']);

Route::get('/leave-request', [StaffLeaveRequestController::class, 'index']);
Route::post('/leave-request', [StaffLeaveRequestController::class, 'create']);
Route::delete('/leave-request/{id}', [StaffLeaveRequestController::class, 'destroy']);
Route::post('/leave-request/{id}', [StaffLeaveRequestController::class, 'update']);

Route::get('/leave-type', [LeaveTypesController::class, 'index']);
Route::post('/leave-type', [LeaveTypesController::class, 'create']);
Route::delete('/leave-type/{id}', [LeaveTypesController::class, 'destroy']);
Route::post('/leave-type/{id}', [LeaveTypesController::class, 'update']);


Route::get('/notification/{id?}', [NotificationSettingController::class, 'index']);
Route::post('/notification', [NotificationSettingController::class, 'create']);
Route::delete('/notification/{id}', [NotificationSettingController::class, 'destroy']);
Route::post('/notification/{id}', [NotificationSettingController::class, 'update']);





Route::get('/homework', [HomeworkController::class, 'index']);
Route::post('/homework', [HomeworkController::class, 'create']);
Route::delete('/homework/{id}', [HomeworkController::class, 'destroy']);
Route::post('/homework/{id}', [HomeworkController::class, 'update']);

Route::get('/roomtype', [RoomTypesController::class, 'index']);
Route::post('/roomtype', [RoomTypesController::class, 'create']);
Route::delete('/roomtype/{id}', [RoomTypesController::class, 'destroy']);
Route::post('/roomtype/{id}', [RoomTypesController::class, 'update']);
Route::get('/certificate', [CertificatesController::class, 'index']);
Route::post('/certificate-view/{id}', [CertificatesController::class, 'certificateView']);
Route::post('/certificate-view-generate/{id}', [CertificatesController::class, 'generateMultiple']);

Route::get('/hostel', [HostelController::class, 'index']);
Route::post('/hostel', [HostelController::class, 'create']);
Route::delete('/hostel/{id}', [HostelController::class, 'destroy']);
Route::post('/hostel/{id}', [HostelController::class, 'update']);

Route::get('/transport-route', [TransportRouteController::class, 'index']);
Route::post('/transport-route', [TransportRouteController::class, 'create']);
Route::delete('/transport-route/{id}', [TransportRouteController::class, 'destroy']);
Route::post('/transport-route/{id}', [TransportRouteController::class, 'update']);

Route::get('/hostel-room', [HostelRoomController::class, 'index']);
Route::post('/hostel-room', [HostelRoomController::class, 'create']);
Route::delete('/hostel-room/{id}', [HostelRoomController::class, 'destroy']);
Route::post('/hostel-room/{id}', [HostelRoomController::class, 'update']);

Route::get('/certificate', [CertificatesController::class, 'index']);
Route::post('/certificate-view/{id}', [CertificatesController::class, 'certificateView']);

Route::post('/certificate', [CertificatesController::class, 'create']);
Route::delete('/certificate/{id}', [CertificatesController::class, 'destroy']);
Route::post('/certificate/{id}', [CertificatesController::class, 'update']);


Route::get('/custome-filds', [CustomFieldsController::class, 'index']);
Route::get('/get-custome-filds', [CustomFieldsController::class, 'getCustomFields']);
Route::post('/custome-filds', [CustomFieldsController::class, 'create']);
Route::delete('/custome-filds/{id}', [CustomFieldsController::class, 'destroy']);
Route::post('/custome-filds/{id}', [CustomFieldsController::class, 'update']);

Route::get('/student', [StudentsController::class, 'index']);
Route::post('/student', [StudentsController::class, 'create']);
Route::delete('/student/{id}', [StudentsController::class, 'destroy']);
Route::post('/student/{id}', [StudentsController::class, 'update']);

Route::get('/student-doc/{id}', [StudentDocController::class, 'index']);
Route::post('/student-doc', [StudentDocController::class, 'create']);
Route::delete('/student-doc/{id}', [StudentDocController::class, 'destroy']);
Route::post('/student-doc/{id}', [StudentDocController::class, 'update']);


Route::get('/student-timeline/{id}', [StudentTimelineController::class, 'index']);
Route::post('/student-timeline', [StudentTimelineController::class, 'create']);
Route::delete('/student-timeline/{id}', [StudentTimelineController::class, 'destroy']);
Route::post('/student-timeline/{id}', [StudentTimelineController::class, 'update']);

Route::get('/student-exam/{id}', [ExamsController::class, 'searchStudentExams']);
Route::post('/student-exam', [ExamsController::class, 'create']);
Route::delete('/student-exam/{id}', [ExamsController::class, 'destroy']);
Route::post('/student-exam/{id}', [ExamsController::class, 'update']);

Route::get('/exam-type', [ExamsController::class, 'examType']);


Route::get('/student-none-promoted', [StudentsController::class, 'searchNonPromotedStudents']);

Route::get('/class-teacher', [ClassTeacherController::class, 'index']);
Route::post('/class-teacher', [ClassTeacherController::class, 'create']);
Route::delete('/class-teacher/{id}', [ClassTeacherController::class, 'destroy']);
Route::post('/class-teacher/{id}', [ClassTeacherController::class, 'update']);

Route::get('/staff', [StaffController::class, 'getStaffbyrole']);
Route::get('/staff/{id}', [StaffController::class, 'getSingleData']);
Route::post('/staff', [StaffController::class, 'create']);
Route::delete('/staff/{id}', [StaffController::class, 'destroy']);
Route::post('/staff/{id}', [StaffController::class, 'update']);
Route::get('/inventory-staff', [StaffController::class, 'getInventoryStaff']);



Route::post('/staff-syllabus', [StaffController::class, 'getStaffSyllabusHTML']);

Route::get('/staff-by-role', [StaffController::class, 'getStaffbyrole']);

Route::get('/classes', [ClassesController::class, 'index']);
Route::post('/classes', [classesController::class, 'create']);
Route::delete('/classes/{id}', [classesController::class, 'destroy']);
Route::post('/classes/{id}', [classesController::class, 'update']);
Route::post('/classes-add', [classesController::class, 'add']);
Route::post('/classes-edit/{id}', [classesController::class, 'editclasses']);
Route::get('/get-classes', [ClassesController::class, 'getClasses']);


Route::get('/fees-remainder', [FeesReminderController::class, 'index']);
Route::post('/fees-remainder', [FeesReminderController::class, 'create']);
Route::delete('/fees-remainder/{id}', [FeesReminderController::class, 'destroy']);
Route::post('/fees-remainder/{id}', [FeesReminderController::class, 'update']);

Route::get('/searchpayment', [SearchPaymentController::class, 'index']);
Route::post('/searchpayment', [SearchPaymentController::class, 'create']);
Route::delete('/searchpayment/{id}', [SearchPaymentController::class, 'destroy']);
Route::post('/searchpayment/{id}', [SearchPaymentController::class, 'update']);

Route::get('/student-attendance', [StudentAttendencesController::class, 'index']);
Route::get('/student-attendance-by-class-section', [StudentAttendencesController::class, 'searchAttendenceClassSection']);
Route::post('/student-attendance', [StudentAttendencesController::class, 'create']);
Route::delete('/student-attendance/{id}', [StudentAttendencesController::class, 'destroy']);
Route::post('/student-attendance/{id}', [StudentAttendencesController::class, 'update']);

Route::get('/attendence-type', [AttendenceTypeController::class, 'index']);
Route::post('/attendence-type', [AttendenceTypeController::class, 'create']);
Route::delete('/attendence-type/{id}', [AttendenceTypeController::class, 'destroy']);
Route::post('/attendence-type/{id}', [AttendenceTypeController::class, 'update']);


Route::get('/syllabus', [SubjectSyllabusController::class, 'index']);
Route::post('/syllabus', [SubjectSyllabusController::class, 'create']);
Route::delete('/syllabus/{id}', [SubjectSyllabusController::class, 'destroy']);
Route::post('/syllabus/{id}', [SubjectSyllabusController::class, 'update']);


Route::get('/search-duefees', [SearchDueFeesController::class, 'getDueStudentFeesDefault']);
Route::post('/search-duefees', [SearchDueFeesController::class, 'create']);
Route::delete('/search-duefees/{id}', [SearchDueFeesController::class, 'destroy']);
Route::post('/search-duefees/{id}', [SearchDueFeesController::class, 'update']);


Route::get('/lessonplan-lesson', [LessonplanLessonController::class, 'getLessonList']);
Route::post('/lessonplan-lesson', [LessonplanLessonController::class, 'create']);
Route::delete('/lessonplan-lesson/{id}', [LessonplanLessonController::class, 'destroy']);
Route::post('/lessonplan-lesson/{id}', [LessonplanLessonController::class, 'update']);


Route::get('/subject-groups', [SubjectGroupsController::class, 'index']);
Route::post('/subject-groups', [SubjectGroupsController::class, 'create']);
Route::post('/subject-groups-create', [SubjectGroupsController::class, 'add']);
Route::delete('/subject-groups/{id}', [SubjectGroupsController::class, 'destroy']);
Route::post('/subject-groups/{id}', [SubjectGroupsController::class, 'update']);


Route::get('/studentfees/{id}', [StudentFeesController::class, 'index']);
Route::post('/student-fees', [StudentFeesController::class, 'getStudentFees']);
Route::post('/studentfees', [StudentFeesController::class, 'create']);
Route::delete('/studentfees/{id}', [StudentFeesController::class, 'destroy']);
Route::post('/studentfees/{id}', [StudentFeesController::class, 'update']);


Route::post('/calculate-balances', [StudentsController::class, 'calculateBalances']);

Route::get('/approve-leave', [StudentApplyleaveController::class, 'index']);
Route::post('/approve-leave', [StudentApplyleaveController::class, 'create']);
Route::get('/approve-leave-change-status/{id}/{role_id}', [StudentApplyleaveController::class, 'changeStatus']);
Route::delete('/approve-leave/{id}', [StudentApplyleaveController::class, 'destroy']);
Route::post('/approve-leave/{id}', [StudentApplyleaveController::class, 'update']);

Route::get('/staff-attendance', [StaffAttendanceController::class, 'index']);
Route::post('/staff-attendance', [StaffAttendanceController::class, 'create']);
Route::delete('/staff-attendance/{id}', [StaffAttendanceController::class, 'destroy']);
Route::post('/staff-attendance/{id}', [StaffAttendanceController::class, 'update']);


Route::get('/income', [IncomeController::class, 'index']);
Route::post('/income', [IncomeController::class, 'create']);
Route::delete('/income/{id}', [IncomeController::class, 'destroy']);
Route::post('/income/{id}', [IncomeController::class, 'update']);

Route::get('/income-head', [IncomeHeadController::class, 'index']);
Route::post('/income-head', [IncomeHeadController::class, 'create']);
Route::delete('/income-head/{id}', [IncomeHeadController::class, 'destroy']);
Route::post('/income-head/{id}', [IncomeHeadController::class, 'update']);

Route::get('/expenses', [ExpensesController::class, 'index']);
Route::post('/expenses', [ExpensesController::class, 'create']);
Route::delete('/expenses/{id}', [ExpensesController::class, 'destroy']);
Route::post('/expenses/{id}', [ExpensesController::class, 'update']);

Route::get('/expense-head', [ExpenseHeadController::class, 'index']);
Route::post('/expense-head', [ExpenseHeadController::class, 'create']);
Route::delete('/expense-head/{id}', [ExpenseHeadController::class, 'destroy']);
Route::post('/expense-head/{id}', [ExpenseHeadController::class, 'update']);

Route::get('/vehicles', [VehiclesController::class, 'index']);
Route::post('/vehicles', [VehiclesController::class, 'create']);
Route::delete('/vehicles/{id}', [VehiclesController::class, 'destroy']);
Route::post('/vehicles/{id}', [VehiclesController::class, 'update']);

Route::get('/vehicle-routes', [VehicleRoutesController::class, 'index']);
Route::post('/vehicle-routes', [VehicleRoutesController::class, 'create']);
Route::delete('/vehicle-routes/{id}', [VehicleRoutesController::class, 'destroy']);
Route::post('/vehicle-routes/{id}', [VehicleRoutesController::class, 'update']);

Route::get('/item', [ItemController::class, 'index']);
Route::get('/get-item', [ItemController::class, 'getItems']);
Route::post('/item', [ItemController::class, 'create']);
Route::delete('/item/{id}', [ItemController::class, 'destroy']);
Route::post('/item/{id}', [ItemController::class, 'update']);


Route::get('/item-stock', [ItemStockController::class, 'index']);
Route::post('/item-stock', [ItemStockController::class, 'create']);
Route::delete('/item-stock/{id}', [ItemStockController::class, 'destroy']);
Route::post('/item-stock/{id}', [ItemStockController::class, 'update']);

Route::get('/item_category', [ItemCategoryController::class, 'index']);
Route::post('/item_category', [ItemCategoryController::class, 'create']);
Route::delete('/item_category/{id}', [ItemCategoryController::class, 'destroy']);
Route::post('/item_category/{id}', [ItemCategoryController::class, 'update']);

Route::get('/item-store', [ItemStoreController::class, 'index']);
Route::post('/item-store', [ItemStoreController::class, 'create']);
Route::delete('/item-store/{id}', [ItemStoreController::class, 'destroy']);
Route::post('/item-store/{id}', [ItemStoreController::class, 'update']);

Route::get('/item-supplier', [ItemSupplierController::class, 'index']);
Route::post('/item-supplier', [ItemSupplierController::class, 'create']);
Route::delete('/item-supplier/{id}', [ItemSupplierController::class, 'destroy']);
Route::post('/item-supplier/{id}', [ItemSupplierController::class, 'update']);

Route::get('/item-issue', [ItemIssueController::class, 'index']);
Route::post('/item-issue', [ItemIssueController::class, 'create']);
Route::delete('/item-issue/{id}', [ItemIssueController::class, 'destroy']);
Route::post('/item-issue/{id}', [ItemIssueController::class, 'update']);


Route::get('/front-event', [EventsController::class, 'index']);
Route::post('/front-event', [EventsController::class, 'create']);
Route::delete('/front-event/{id}', [EventsController::class, 'destroy']);
Route::post('/front-event/{id}', [EventsController::class, 'update']);

Route::get('/grades', [GradesController::class, 'index']);
Route::post('/grades', [GradesController::class, 'create']);
Route::delete('/grades/{id}', [GradesController::class, 'destroy']);
Route::post('/grades/{id}', [GradesController::class, 'update']);

Route::get('/frontcms-menus', [FrontCmsMenusController::class, 'index']);
Route::post('/frontcms-menus', [FrontCmsMenusController::class, 'create']);
Route::delete('/frontcms-menus/{id}', [FrontCmsMenusController::class, 'destroy']);
Route::post('/frontcms-menus/{id}', [FrontCmsMenusController::class, 'update']);

Route::get('/alumni-event', [AlumniEventsController::class, 'index']);
Route::post('/alumni-event', [AlumniEventsController::class, 'create']);
Route::delete('/alumni-event/{id}', [AlumniEventsController::class, 'destroy']);
Route::post('/alumni-event/{id}', [AlumniEventsController::class, 'update']);
/* for content manangment  */

/* for content manangment  */

Route::get('/content-section', [ContentSectionController::class, 'index']);
Route::post('/content-section', [ContentSectionController::class, 'create']);
Route::delete('/content-section/{id}', [ContentSectionController::class, 'destroy']);
Route::post('/content-section/{id}', [ContentSectionController::class, 'update']);



Route::get('/content-for-upload', [ContentForController::class, 'index']);
Route::post('/content-for-upload', [ContentForController::class, 'create']);
Route::delete('/content-for-upload/{id}', [ContentForController::class, 'destroy']);
Route::post('/content-for-upload/{id}', [ContentForController::class, 'update']);


Route::get('/content', [ContentsController::class, 'index']);
Route::post('/content', [ContentsController::class, 'create']);
Route::delete('/content/{id}', [ContentsController::class, 'destroy']);
Route::post('/content/{id}', [ContentsController::class, 'update']);



/* for content manangment  end */









/* api logic end  */

Route::get('/studentfee/searchpayment', [SiteController::class, 'studentFeeSearchPayment']);
Route::get('/studentfee/feesearch', [SiteController::class, 'studentFeeSearch']);
/*   Route::get('/classes', [SiteController::class, 'classes']); */
/*  Route::get('/sections', [SiteController::class, 'sections']); */
Route::get('/student/bulkmail', [SiteController::class, 'studentBulkMail']);

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


/* }); */


Route::get('site/logout', [SiteController::class, 'logout'])->name('admin.logout');
