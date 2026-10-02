<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Models\RequestCheckoutCredit;
use App\Models\Specific\CreditLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Plivo\Message;
use Tohidplus\Mellat\Facades\Mellat;
use App\Models\Specific\Checkout;
use App\Models\Specific\Wallet;

class CreditController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [
            'user' => $user,
            'activeMenu' => 'wallets',
            'subActiveMenu' => 'credit'
        ];
        return view('front.pages.profile.credit.index', $data);
    }

    public function store(Request $request)
    {
        $request->merge(['price' => (int)str_replace(',', '', $request->get('price'))]);
        $this->validate($request, [
            'price' => 'required|numeric|max:10000000|min:10000'
        ]);
        Mellat::setCallBackUrl(route('front.profile.credit.verify'));
        Mellat::set($request->get('price'));
        return Mellat::redirect(function ($error) {
            setSession([
                'header' => 'خطا از طرف درگاه',
                'message' => $error,
                'type' => 'error'
            ]);
            return back();
        });
    }

    public function verify(Request $request)
    {
        return Mellat::verify(function ($log) {
            auth()->user()->credit += ((int)$log->amount / 10);
            auth()->user()->save();
            CreditLog::query()->create([
                'price' => ((int)$log->amount / 10),
                'status' => CreditLog::increaseStatus,
                'type' => CreditLog::chargeType,
                'user_id'=>auth()->user()->id
            ]);
            setSession([
                'header' => 'افزایش موجودی موفق',
                'message' => 'موجودی شما با موفقیت افزایش پیدا کرد.',
                'type' => 'success'
            ]);
            return redirect()->route('front.profile.credit.index');
        }, function ($log) {
            setSession([
                'header' => 'پرداخت نا موفق',
                'message' => $log->message,
                'type' => 'error'
            ]);
            return redirect()->route('front.profile.credit.index');
        });
    }

    /**
     * Show page request
     *
     * @return \Response
     */
    public function requestCreditIndex()
    {
        $user = auth()->user();
        $data = [
            'pageTitle' => 'درخواست های تسویه موجودی',
            'activeMenu' => 'wallets',
            'subActiveMenu' => 'request-credit',
            'user' => $user,
            'bankCarts' => $user->bankCarts,
            'request_checkout_credits' => RequestCheckoutCredit::where('user_id', '=', auth()->user()->id)->latest('id')->paginate(20)
        ];

        return view('front.pages.profile.request_checkout_credit.index', $data);
    }

    /**
     * Send request for checkout credit via users
     *
     * @param Request $request
     * @return \Response
     */
    public function requestCredit(Request $request)
    {
        $this->validate($request, [
            'bank_cart_id' => 'required',
            'price' => ['required', function ($attr, $value, $fail) {
                if (auth()->user()->requestCheckoutCredit()->count())
                    return $fail('شمار در حال حاضر یک درخواست در حال بررسی دارید و تا مشخص نشدن آن نمی توانید درخواست دیگری داشته باشید');
                $price = (int)str_replace(',', '', $value);

                if (!is_numeric($price))
                    return $fail('لطفا عدد را به انگلیسی وارد نمایید ');
                if ($price > auth()->user()->credit)
                    return $fail('مبلغ درخواستی شما بیشتر از موجودی حسابتان است ');
            }]
        ]);

        $request->request->add(['user_id' => auth()->user()->id]);

        RequestCheckoutCredit::create($request->all());

        return redirect()->back();
    }
}
