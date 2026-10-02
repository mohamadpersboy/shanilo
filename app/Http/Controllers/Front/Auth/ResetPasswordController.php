<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Base\PasswordResetMobile;
use App\Models\Base\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm()
    {
        $passwordResetMobile=PasswordResetMobile::find(\Session::get('pass_reset_mobile'));
        $data=[
            'breadcrumbs'=>[
                'active'=>'تغییر رمز عبور'
            ],
            'passwordResetMobile'=>$passwordResetMobile,
        ];
        return view('front.pages.auth.password.step3',$data);
    }

    protected function sendResetResponse($response=null)
    {
        setSession([
            'header' => 'تغییر موفق رمز عبور',
            'message' => 'رمز عبور شما با موفقیت تغییر یافت.',
            'type' => 'success'
        ], 'notification');

        if(\request()->ajax()){
            return ['url'=>route('front.home.index')];
        }else{

            return response()->redirectTo('/');
        }
    }

    public function reset(Request $request)
    {
        $this->validate($request,[
            'id'=>'required|check_hash:'.$request->get('sid').','.true,
            'password'=>'required|min:6|confirmed',
        ]);
        $passwordResetMobile=PasswordResetMobile::find($request->id);
        $user=User::where('mobile',$passwordResetMobile->mobile)->first();
        $user->update(['password'=>$request->get('password')]);
        \Session::forget('pass_reset_mobile');
        \Session::forget('hashed');
        return $this->sendResetResponse();
    }
}
