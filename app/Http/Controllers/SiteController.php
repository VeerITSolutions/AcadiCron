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
     /*    $app_name = SchSettings::first()->name;

        // Validation
        $rules = [
            'username' => 'required|email',
            'password' => 'required',
            'captcha' => 'required_if:is_captcha,true',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('captcha_image', $this->generateCaptcha());
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $SchSettings = SchSettings::first();

            $sessionData = [
                'id' => $user->id,
                'username' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles,
                'date_format' => $SchSettings->date_format,
                'currency_symbol' => $SchSettings->currency_symbol,
                'currency_place' => $SchSettings->currency_place,
                'start_month' => $SchSettings->start_month,
                'start_week' => date('w', strtotime($SchSettings->start_week)),
                'school_name' => $SchSettings->name,
                'timezone' => $SchSettings->timezone,
                'language' => [
                    'lang_id' => $SchSettings->lang_id,
                    'language' => $SchSettings->language,
                ],
                'is_rtl' => $SchSettings->is_rtl,
                'theme' => $SchSettings->theme,
                'gender' => $user->gender,
            ];

            if ($sessionData['is_rtl'] === 'disabled') {
                $language = $this->language_model->find($sessionData['language']['lang_id']);
                if ($this->getRtlLanguages($language->short_code)) {
                    $sessionData['is_rtl'] = 'enabled';
                }
            }

            Session::put('admin', $sessionData);

            $role = $this->getStaffRole();
            $role_name = json_decode($role)->name;
            $this->setUserLog($request->input('username'), $role_name);

            return redirect(Session::get('redirect_to', 'admin/admin/dashboard'));
        } else {
            return redirect()->back()
                ->with('error_message', 'Invalid username or password')
                ->with('name', $app_name)
                ->with('captcha_image', $this->generateCaptcha());
        } */
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
