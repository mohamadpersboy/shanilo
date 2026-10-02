<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Base\PasswordResetMobile;
use Carbon\Carbon;
use DB;
use foo\bar;
use function foo\func;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Base\User;
use Smsir;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        $data=[
            'breadcrumbs'=>[
                'active'=>'فراموشی رمز عبور'
            ]
        ];
        return view('front.pages.auth.password.step1',$data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function sendResetMobile(Request $request)
    {
        $this->validate($request,[
            'mobile'=>'required|mobile|exists:users'
        ],[
            'mobile.exists'=>'شماره همراه وارد شده در سیستم موجود نیست.'
        ]);
        $response=DB::transaction(function () use ($request){
            $code=rand(10000,99999);
            $hashed=str_replace('/','',bcrypt($code));
            PasswordResetMobile::create([
                'mobile'=>$request->get('mobile'),
                'code'=>$code,
                'token'=>$hashed,
                'expired_at'=>Carbon::now()->addMinutes(15)
            ]);
            //$this->sendMobileConfirmationSMS($request->get('mobile'),$code);
            Smsir::ultraFastSend(['VerificationCode'=>$code],31279,$request->get('mobile'));
            \Session::put('hashed',$hashed);
            return ['url'=>route('front.auth.password.mobile.confirm')];
        });
        return $response;
    }

    public function showMobileConfirmation()
    {
        return view('front.pages.auth.password.step2');
    }

    public function confirm(Request $request)
    {
        $this->validate($request,[
            'code'=>'required|check_hash:'.$request->get('hashed').','.true.'|exists:password_reset_mobiles'
        ],[
            'code.check_hash'=>'کد تایید وارد شده نامعتبر است.',
            'code.exists'=>'کد تایید وارد شده نامعتبر است.',
            'code.required'=>'لطفا کد تایید را وارد نمایید.',
        ]);
        $passwordResetMobile=PasswordResetMobile::where('code',$request->get('code'))
            ->where('expired_at','>',Carbon::now())->first();
        if(!$passwordResetMobile){
            return \response()->json(['errors'=>['code'=>['تاریخ کد تایید منقضی شده است، لطفا مجددا تلاش نمایید.']]],422);
        }
        \Session::put('pass_reset_mobile',$passwordResetMobile->id);
        return ['url'=>route('front.password.reset')];
    }

    public function sendMobileConfirmationSMS($mobile,$code)
    {
        $message='کد تایید فراموشی رمز عبور: %code%'.PHP_EOL;
        $message.='در صورتی که درخواست فراموشی رمز عبور توسط شما ارسال نشده است این پیامک را حذف نمایید.'.PHP_EOL;
        $message.='shanilo.com';
        $message=str_replace('%code%',$code,$message);
        Smsir::send([$message],[$mobile]);
    }

}
