<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App;
use App\Models\Base\User;
use App\Mail\EmailConfirmation;
use Mail;
use Smsir;

class FrontLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return  'mobile';
    }

    public function showLoginForm()
    {
        if(\Auth::check()){
            return redirect()->route('front.home.index');
        } else {
            $items = [
                ["title" => "Sing In","link" => "#"]
            ];
            return view('front.pages.auth.login',compact('items'));
        }
    }


    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        if($request->ajax()){
            return response()->json(['url'=>back()->getTargetUrl()]);
        }else{
            if(redirect()->back()){
                return $this->authenticated($request, $this->guard()->user())
                    ?: redirect()->back();
            } else {
                return $this->authenticated($request, $this->guard()->user())
                    ?: redirect()->intended($this->redirectPath());
            }
        }
    }

    protected function authenticated(Request $request,User $user){
        $previous_session = $user->session_id;

        if ($previous_session) {
            \Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = \Session::getId();
        Auth::user()->save();
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            if(\Auth::user()->status == 0){
                $this->guard()->logout();
                $request->session()->flush();
                $request->session()->regenerate();
                setSession([
                    'header' => 'انسداد حساب',
                    'message' => 'اطلاعات کاربری شما مسدود شده است، لطفا با مدیریت وبسایت تماس حاصل فرمایید.',
                    'type' => 'error'
                ], 'notification');
                return response()->json(['url'=>'/']);
            } elseif(\Auth::user()->confirm == 0){
                $random=rand(100000,999999);
                $user=Auth::user();
                $user->update(['hashed'=>md5($random)]);
                $this->guard()->logout();
                setSession([
                    'header' => 'فعال سازی حساب',
                    'message' => 'لطفا قبل از ورود نسبت به فعال سازی حساب کاربری خود اقدام نمایید.',
                    'type' => 'warning'
                ], 'notification');
                //Smsir::sendVerification([(new RegisterController())->message($random)],[$user->mobile]);
                Smsir::ultraFastSend(['VerificationCode'=>$random],31278,$user->mobile);
                return response()->json(['url'=>route('front.auth.register.mobile')]);
            } else {
                return $this->sendLoginResponse($request);
            }
        } else {
            return response()->json(['errors'=>['mobile'=>['نام کاربری یا رمز عبور صحیح نمی باشد.']]],422);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('front.home.index');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'mobile'=> 'required|string',
            'password' => 'required|string',
        ]);
    }
}
