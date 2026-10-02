<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailNewsletter;
use App\Models\Base\Newsletter;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\TemporaryUser;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\Base\User;
use App\Mail\EmailConfirmation;
use Mail;
use Smsir;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function showRegistrationForm()
    {
        $data = [
            'breadcrumbs' => [
                'active' => 'عضویت در سایت'
            ],
            'pageTitle' => 'عضویت در سایت',
        ];
        return view('front.pages.auth.register.step1', $data);
    }

    protected function validator(Request $request)
    {
        $request->merge(['uid' => trim(str_replace('@', '', $request->get('uid')))]);
        $this->validate($request, [
            'name' => 'required|max:60',
            'family' => 'required|max:60',
            'email' => 'required|email|unique:users,email',
            'uid' => 'required|regex:/^[A-Za-z\d_-]+$/|unique:users,uid|unique:shops,uid',
            'password' => 'required|min:6|confirmed',
            'mobile' => 'required|mobile|unique:users,mobile',
            'agreement' => 'required',
        ], [
            'uid.regex' => 'نام کاربری فقط باید حاوی کاراکتر  انگلیسی و اعداد باشد.'
        ], [
            'uid' => 'نام کاربری',
            'agreement' => 'موافقت'
        ]);
    }


    public function showMobileForm()
    {
        if (\Auth::check()) {
            return redirect()->route('front.home.index');
        } else {
            $items = [
                ["title" => "تایید شماره همراه", "link" => "#"]
            ];
            return view('front.pages.login-register.confirm-mobile', compact('items'));
        }
    }

    protected function create(Request $request)
    {
        Smsir::ultraFastSend(['VerificationCode'=>$request->get('random')],31278,$request->get('mobile'));
        return TemporaryUser::create($request->all());
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public function register(Request $request)
    {
        $this->validator($request);
        $random = rand(100000, 999999);
        $request->merge(['random' => $random]);
        $request->merge(['hashed' => md5($random)]);
        $temporaryUser= $this->create($request);
        \Session::put('tmp_id',$temporaryUser->id);
        return response()->json([
            'url' => route('front.auth.register.mobile')
        ]);
    }

    public function confirm(Request $request)
    {
        $table=Auth::check()?'users':'temporary_users';
        $this->validate($request, [
            'code' => "required|exist_hashed:{$table},hashed"
        ], [
            'code.exist_hashed' => 'کد وارد شده نامعتبر است.'
        ]);


        if($user=User::where('hashed',md5($request->get('code')))->first()){
            $user->update(['confirm'=>1]);
        }else{
            $temporaryUser = TemporaryUser::where('hashed', md5($request->get('code')))->first();
            $user=$temporaryUser->transmit();
        }
        Session::forget('tmp_id');
        Auth::login($user);
        setSession([
            'header' => 'فعال سازی موفق',
            'type' => 'success',
            'message' => 'فعال سازی حساب کاربری شما با موفقیت انجام گرفت.'], 'notification');
        return response()->json(['url' => route('front.auth.register.confirmed')]);
    }

    public function showMobileConfirmation()
    {
        $data=[
            'temporaryUser'=>Auth::user()?:TemporaryUser::findOrFail(Session::get('tmp_id'))
        ];
        return view('front.pages.auth.register.step2',$data);
    }

    public function showFavoriteCategories()
    {
        $data=[
            'productCategories'=>ProductCategory::visible()->parents()->orderBy('position')->get()
        ];
        return view('front.pages.auth.register.step3',$data);
    }

    public function setFavoriteCategories(Request $request)
    {
        $user=Auth::user();
        $productCategories=$request->get('categories')?:[];
        $user->favoriteCategories()->sync($productCategories);
        return [
            'url'=>route('front.home.index')
        ];
    }

    public function message($random)
    {
        $message = "کد تایید شما: (%code%)" . PHP_EOL;
        $message .= "shanilo.com";
        $message = str_replace('%code%', $random, $message);
        return $message;
    }

}
