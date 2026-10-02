<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Requests\Front\User\PasswordRequest;
use App\Http\Controllers\Controller;
use Auth;
class PasswordController extends Controller
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Password
    # Change user password from user dashboard
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function index()
    {
        $user = \Auth::user();
        $data = [
            'breadcrumbs' => [
                'active' => 'تغییر رمز عبور'
            ],
            'activeMenu' => 'changepass',
            'pageTitle' => 'تغییر رمز عبور',
            'user' => $user,
        ];
        return view('front.pages.profile.password.index', $data);
    }

    public function update(PasswordRequest $request)
    {
        Auth::user()->update([
            'password' => $request->get('password')
        ]);
        return [
            'header'=>'تغییر رمز موفق',
            'type'=>'success',
            'message'=>'رمز عبور با موفقیت تغییر یافت.'
        ];
    }
}
