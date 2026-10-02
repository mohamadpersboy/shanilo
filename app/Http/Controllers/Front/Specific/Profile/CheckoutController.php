<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Models\Specific\Checkout;
use App\Models\Specific\Wallet;
use Baum\Extensions\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends ProfileController
{
    public function index()
    {
        $user=\Auth::user();
        $data=[
            'pageTitle'=>'درخواست های تسویه حساب',
            'activeMenu'=>'wallets',
            'subActiveMenu'=>'checkouts',
            'user'=>$user,
            'shops'=>$user->shops,
            'bankCarts'=>$user->bankCarts,
            'checkouts'=>Checkout::whereIn('wallet_id',Wallet::whereIn('shop_id',$user->shops()
                ->pluck('id')->toArray())->pluck('id')->toArray())->latest()->paginate(PROFILE_PAGINATION_COUNT)
        ];
        return view('front.pages.profile.checkout.index',$data);
    }

    public function store(Request $request)
    {
        $request->merge(['price'=>(int)str_replace(',','',$request->get('price'))]);
        $this->validator($request);
        $wallet=Wallet::find($request->get('wallet_id'));
        if($wallet->checkouts()->where('status','pending')->exists()){
            return response()->json(['errors'=>['wallet_id'=>['شما قبلا یک درخواست تسویه برای کیف پول این فروشگاه ارسال کرده اید.']]],422);
        }
        if($request->get('price')>$wallet->removeable){
            return response()->json(['errors'=>['price'=>['مبلغ درخواستی نباید بیشتر از حد قابل برداشت باشد.']]],422);
        }
        Checkout::create($request->all());
        setSession([
            'header'=>'درخواست تسویه حساب',
            'type'=>'info',
            'message'=>'درخواست شما با موفقیت ثبت و مبلغ پس تایید مدیر وبسایت به حسابتان واریز خواهد شد.'
        ]);
        return [
            'url'=>back()->getTargetUrl()
        ];

    }

    /**
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $wallets = implode(',', Wallet::whereIn('shop_id', auth()->user()->shops()->pluck('id')->toArray())->pluck('id')->toArray());
        $bankCarts = implode(',', auth()->user()->bankCarts()->pluck('id')->toArray());
        $this->validate($request, [
            'wallet_id' => 'required|in:' . $wallets,
            'bank_cart_id' => 'required|in:' . $bankCarts,
            'price' => 'required|numeric|min:10000'
        ], [
            'wallet_id.in' => 'اطلاعات ارسال شده نامعتبر است.',
            'bank_cart_id.in' => 'اطلاعات ارسال شده نامعتبر است.',
        ], [
            'wallet_id' => 'فروشگاه',
            'bank_cart_id' => 'کارت بانکی',
            'price' => 'مبلغ درخواستی'
        ]);
    }
}
