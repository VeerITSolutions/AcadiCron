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

        if (Auth::attempt($credentials)) {
            /* return redirect()->intended('/'); */

            print_r('true');die;
        }
        print_r('false');die;
        return redirect('/')->with('error', 'Invalid credentials. Please try again.');
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
