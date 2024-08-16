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
use App\Models\User;
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

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');


        $user = Staff::where('email', $request->username)->first();




            // Check if the password matches using CodeIgniter's hashing method
            if (password_verify($request->password, $user->password)) {


                Auth::guard('staff')->login($user);



            return redirect()->route('admin.dashboard');  // Redirect after login
    } else {


        return redirect()->back()->with('error', 'Invalid credentials');
    }


    }

    public function dashboard(Request $request){
        return view('admin.dashboard');
    }

    public function logout(Request $request)
{
    // Log out the user
    Auth::guard('staff')->logout();

    // Invalidate the session
    $request->session()->invalidate();

    // Regenerate the session token to prevent session fixation attacks
    $request->session()->regenerateToken();

    // Redirect the user to the login page (or wherever you want)

    /* // Error message
return redirect()->back()->with('error', 'Your custom error message here');

// Success message
return redirect()->back()->with('success', 'Your custom success message here');

// Info message
return redirect()->back()->with('info', 'Your custom info message here');

// Warning message
return redirect()->back()->with('warning', 'Your custom warning message here'); */
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