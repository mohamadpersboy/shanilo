<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Models\Specific\BankCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankCartController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $data = [
            'pageTitle' => 'حسابهای بانکی من',
            'activeMenu' => 'wallets',
            'subActiveMenu' => 'bankcarts',
            'bankCarts' => $user->bankCarts,
            'user' => $user
        ];
        return view('front.pages.profile.bankcart.index', $data);
    }

    public function create()
    {
        return [
            'view' => \View::make('front.pages.profile.bankcart.create')->render()
        ];
    }

    public function store(Request $request)
    {
        $this->validator($request);
        auth()->user()->bankCarts()
            ->create($request->all());
        setSession([
            'header' => 'افزودن کارت بانکی',
            'type' => 'success',
            'message' => 'اطلاعات حساب جدید با موفقیت ثبت گردید.'
        ]);
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    public function edit(BankCart $bankCart)
    {
        $this->checkIfBankCartBelongsToUser($bankCart);
        $data = [
            'bankCart' => $bankCart,
            'edit' => true
        ];
        return [
            'view' => \View::make('front.pages.profile.bankcart.edit', $data)->render()
        ];
    }

    public function update(Request $request, BankCart $bankCart)
    {
        $this->checkIfBankCartBelongsToUser($bankCart);
        $this->validator($request);
        $bankCart->update($request->all());
        setSession([
            'header' => 'ویرایش کارت بانکی',
            'type' => 'success',
            'message' => 'اطلاعات کارت بانکی با موفقیت ویرایش گردید.'
        ]);
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    public function destroy(BankCart $bankCart)
    {
        $this->checkIfBankCartBelongsToUser($bankCart);
        $bankCart->delete();
        setSession([
            'header' => 'حذف کارت بانکی',
            'type' => 'success',
            'message' => 'کارت بانکی با موفقیت حذف گردید.'
        ]);
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    /**
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $this->validate($request, [
            'sheba_no' => 'required|iban',
            'cart_no' => 'required',
            'owner' => 'required',
            'expire_month' => 'required',
            'expire_year' => 'required'
        ], [
            'sheba_no.iban' => 'فرمت شماره شبا صحیح نمی باشد.'
        ], [
            'sheba_no' => 'شماره شبا',
            'cart_no' => 'شماره کارت',
            'owner' => 'نام دارنده کارت',
            'expire_month' => 'ماه انقضاء',
            'expire_year' => 'سال انقضاء',
        ]);
    }

    /**
     * @param BankCart $bankCart
     */
    protected function checkIfBankCartBelongsToUser(BankCart $bankCart)
    {
        if ($bankCart->user_id != auth()->id()) {
            abort(404);
        }
    }
}
