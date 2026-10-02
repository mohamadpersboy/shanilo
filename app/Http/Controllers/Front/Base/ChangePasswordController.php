<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Front\User\PasswordRequest;

use Auth;

class ChangePasswordController extends Controller
{
    public function index()
    {
        $data=[
            'breadcrumbs'=>[
                'active'=>'تغییر رمز عبور'
            ],
            'user'=>Auth::user(),
            'activeMenu'=>'change-pass',
            'pageTitle'=>'تغییر رمز عبور'
        ];
        return view('front.pages.profile.change-pass',$data);
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
