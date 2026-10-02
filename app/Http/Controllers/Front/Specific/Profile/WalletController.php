<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Grid\Front\Profile\CreditLogGrid;
use App\Http\Controllers\Front\Base\ProfileController;
use App\Models\RequestCheckoutCredit;
use App\Models\Specific\CreditLog;
use App\Models\Specific\Order;
use App\Models\Specific\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SrkGrid\GridView\Grid;
use Symfony\Component\HttpFoundation\JsonResponse;

class WalletController extends ProfileController
{
    public function index()
    {
        $user = \Auth::user();
        $requestCheckout = RequestCheckoutCredit::query()->whereUserId(auth()->user()->id)->whereStatus('pending')->limit(1)->first();
        $data = [
            'pageTitle' => 'اطلاعات حساب و موجودی',
            'activeMenu' => 'wallets',
            'user' => $user,
            'subActiveMenu' => 'wallets',
            'wallets' => Wallet::whereIn('shop_id', $user->shops()->pluck('id')->toArray())->get(),
            'requestCheckout' => optional($requestCheckout)->price
        ];
        return view('front.pages.profile.wallet.index', $data);
    }

    public function transactions(Wallet $wallet)
    {
        $this->checkIfWalletBelongsToUser($wallet);
        $walletTransactions = $wallet->walletTransactions()->with(['order'])->latest()->get();

        return [
            'view' => \View::make('front.partial.items.wallet-transactions', compact('walletTransactions', 'wallet'))->render()
        ];
    }

    /**
     * @param Wallet $wallet
     */
    protected function checkIfWalletBelongsToUser(Wallet $wallet)
    {
        if ($wallet->shop->user_id != auth()->id()) {
            abort(404);
        }
    }

    public function creditLog()
    {
        $data = CreditLog::query()->where('user_id', '=', auth()->user()->id)->latest('id');
        $grid = $this->html() . Grid::make(CreditLogGrid::class, $data);
        return response()->json(['status' => JsonResponse::HTTP_OK, 'view' => $grid]);
    }

    protected function html()
    {
        return '<div class="close_btn"><i class="i-cancel"></i></div> <div class="title_style7"><span class="title">موجودی کاربر</span></div> <div class="text_style1">تراکنش های کیف پول</div>';

    }
}
