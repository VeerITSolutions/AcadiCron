<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\SchSettings;
use App\Models\CmsProgram;
use App\Models\FrontCmsPrograms;
use App\Models\Staff;
use App\Models\Students;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class SiteController extends Controller
{


    public function showLoginForm()
    {
        $app_name = SchSettings::first()->name;



        $notices = config('custom.front_notice_content');



        return view('admin.login', [
            'title' => 'Login',
            'name' => $app_name,
            'notice' => $notices,
            'school' => SchSettings::first(),
            'is_captcha' => config('app.captcha.enabled'),
        ]);
    }


    public function attendanceDashboard(Request $request)
    {
        $session_id = $request->sessionId;
        $attendances = DB::table('student_attendences')
            ->where('attendence_type_id', 1)
            ->whereDate('date', Carbon::today())
            ->count();

        $staffattendances = DB::table('staff_attendance')
            ->where('staff_attendance_type_id', 1)
            ->whereDate('date', Carbon::today())
            ->count();

        $totalstudent = DB::table('student_session')
            ->where('session_id', $session_id)
            ->count();
        $totalstaff = DB::table('staff')
            ->where('is_active', '1')
            ->count();


        // Return paginated data with pagination details
        return response()->json([
            'success' => true,
            'todayattendance' => $attendances, // Only return the current page data
            'totalstudents' => $totalstudent,
            'staffattendance' => $staffattendances,
            'totalstaff' => $totalstaff,
            'current_date' => Carbon::today()->format('Y-m-d'),

        ], 200);
    }

    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // First, try to find the user with the email
        $user = Staff::with('roles')->where('email', $request->username)->first();

        // If no staff user found, look for a general user
        if (!$user) {
            $user = User::where('username', $request->username)->first();
        }

        // If user is found, check the password
        if ($user) {
            if (($user instanceof Staff && password_verify($request->password, $user->password)) ||
                ($user instanceof User && $request->password === $user->password)
            ) {
                // Log the user in
                Auth::login($user);

                // Generate a token for the user
                $token = $user->createToken('YourAppToken')->plainTextToken;

                // Prepare user data

                if ($user instanceof Staff) {
                    $userData = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'roles' => []
                    ];
                } elseif ($user instanceof User) {

                    if ($user->role == 'student') {
                        $get_session = SchSettings::first();
                        $currentYear = $get_session ? $get_session->session_id : null;

                        $get_student = Students::where('students.id', $user->user_id)
                            ->leftJoin('student_session', function ($join) use ($currentYear) {
                                $join->on('student_session.student_id', '=', 'students.id')
                                    ->where('student_session.session_id', '=', $currentYear);
                            })
                            ->leftJoin('classes', 'classes.id', '=', 'student_session.class_id')
                            ->leftJoin('sections', 'sections.id', '=', 'student_session.section_id')
                            ->select(
                                'students.*',
                                'student_session.class_id as class_id',
                                'student_session.section_id as section_id',
                                'student_session.id as student_session_id',
                                'classes.class as class_name',
                                'sections.section as section_name'
                            )
                            ->first();

                        if ($get_student) {

                            $user_username = $get_student->firstname;
                            $user_last_name = $get_student->lastname;
                        } else {
                            $user_username = 'N/A';
                            $user_last_name = 'N/A';
                        }



                        $userData = [
                            'name' => $user_username,
                            'surname' => $user_last_name,
                            'user_data' => $get_student,

                            'roles' => []
                        ];
                    }

                    if ($user->role == 'parent') {
                        $get_session = SchSettings::first();
                        $currentYear = $get_session ? $get_session->session_id : null;

                        $get_student = Students::where('students.parent_id', $user->id)
                            ->leftJoin('student_session', function ($join) use ($currentYear) {
                                $join->on('student_session.student_id', '=', 'students.id')
                                    ->where('student_session.session_id', '=', $currentYear);
                            })
                            ->leftJoin('classes', 'classes.id', '=', 'student_session.class_id')
                            ->leftJoin('sections', 'sections.id', '=', 'student_session.section_id')
                            ->select(
                                'students.*',
                                'student_session.class_id as class_id',
                                'student_session.section_id as section_id',
                                'student_session.id as student_session_id',
                                'classes.class as class_name',
                                'sections.section as section_name'
                            )
                            ->first();


                        $guardian_name = $get_student->guardian_name;



                        $userData = [
                            'name' => $guardian_name,
                            'surname' => '',
                            'user_data' => $get_student,
                            'roles' => []
                        ];
                    }
                }


                // Handle roles based on user type
                if ($user instanceof Staff) {
                    $userData['roles'] = $user->roles->map(function ($role) {
                        return [
                            'id' => $role->id,
                            'is_superadmin' => $role->is_superadmin,
                            'name' => $role->name,

                        ];
                    });
                } elseif ($user instanceof User) {
                    // Implement your logic for User roles here


                    if ($user->role == 'student') {
                        $userData['roles'] = [
                            [
                                'id' => '10', // Assuming User has a role_id field
                                'is_superadmin' => 0, // Assuming User has this field
                                'name' => $user->role, // Assuming User has this field
                            ]
                        ];
                    }

                    if ($user->role == 'parent') {

                        $userData['roles'] = [
                            [
                                'id' => '11', // Assuming User has a role_id field
                                'is_superadmin' => 0, // Assuming User has this field
                                'name' => $user->role, // Assuming User has this field
                            ]
                        ];
                    }
                }

                if ($user->role == 'student') {

                    $get_student =  Students::where('id', $user->user_id)->first();
                    $userData['user_id'] = $get_student->id;
                } else {
                    $userData['user_id'] = $user->id;
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Successfully authenticated',
                    'token' => $token,
                    'users' => $userData,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication failed',
                ], 401);
            }
        }

        // If no user is found
        return response()->json([
            'success' => false,
            'message' => 'User not found',
        ], 404);
    }



    public function logout(Request $request)
    {
        // Log out the user
        Auth::guard('staff')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token to prevent session fixation attacks
        $request->session()->regenerateToken();


        return redirect('/')->with('success', 'Logout Successfully!');
    }

    protected function generateCaptcha()
    {
        // Generate and return captcha image URL or data here
    }

    protected function getRtlLanguages($shortCode)
    {
        // Implement logic to determine RTL languages
    }

    protected function getStaffRole()
    {
        // Implement logic to get staff role
    }

    protected function setUserLog($username, $role_name)
    {
        // Implement logic to log user activity
    }
}
