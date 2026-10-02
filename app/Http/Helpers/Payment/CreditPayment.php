<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 11/26/2018
 * Time: 11:44 AM
 */

namespace App\Http\Helpers\Payment;


use App\Events\OrderStatusChanged;
use App\Models\Specific\CartDetail;
use App\Models\Specific\CreditLog;
use App\Models\Specific\Plan;
use App\Models\Specific\SpecialSell;
use App\Models\Specific\SpecialSuggestion;

class CreditPayment implements PaymentInterface
{

    public function payOrder(CartDetail $cartDetail)
    {
        if (auth()->user()->credit >= $cartDetail->total()) {
            $order = \DB::transaction(function () use ($cartDetail) {
                $order = $cartDetail->transmit();
                $order->confirm();
                $order->payment->update(['status' => 'successful']);
                auth()->user()->credit -= $order->total;
                auth()->user()->save();

                CreditLog::query()->create([
                    'price' => $order->total,
                    'status' => CreditLog::decreaseStatus,
                    'type' => CreditLog::paymentType,
                    'user_id' => auth()->user()->id
                ]);
                event(new OrderStatusChanged($order));
                return $order;
            });
            return redirect()->route('front.payment.result', $order);
        } else {
            return $this->creditIsNotEnoughMessage();
        }
    }

    public function payFirstPageSpecialSuggestion(SpecialSuggestion $specialSuggestion, Plan $plan)
    {
        if (auth()->user()->credit < $plan->price) {
            return $this->creditIsNotEnoughMessage();
        }
        $firstPageSpecialSuggestion = \DB::transaction(function () use ($plan, $specialSuggestion) {
            auth()->user()->credit -= $plan->price;
            auth()->user()->save();
            return $specialSuggestion->addToFirstPage($plan);
        });
        $message = 'محصول شما تا زمان %expires_at% در بخش پیشنهادات ویژه صفحه اصلی وبسایت نمایش داده خواهد شد.';
        setSession([
            'header' => 'پیشنهادات ویژه صفحه اصلی وبسایت',
            'message' => str_replace('%expires_at%', ShowDate($firstPageSpecialSuggestion->expires_at), $message),
            'type' => 'success',
        ], 'planOrdered');
        \Session::flash('payment',$firstPageSpecialSuggestion->payment);
        return back();
    }

    public function payFirstPageSpecialSell(SpecialSell $specialSell, Plan $plan)
    {
        if (auth()->user()->credit < $plan->price) {
            return $this->creditIsNotEnoughMessage();
        }
        $firstPageSpecialSell = \DB::transaction(function () use ($plan, $specialSell) {
            auth()->user()->credit -= $plan->price;
            auth()->user()->save();
            return $specialSell->addToFirstPage($plan);
        });
        $message = 'محصول شما تا زمان %expires_at% در بخش فروش ویژه صفحه اصلی وبسایت نمایش داده خواهد شد.';
        setSession([
            'header' => 'فروش ویژه صفحه اصلی وبسایت',
            'message' => str_replace('%expires_at%', ShowDate($firstPageSpecialSell->expires_at), $message),
            'type' => 'success',
        ], 'planOrdered');
        \Session::flash('payment',$firstPageSpecialSell->payment);
        return back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function creditIsNotEnoughMessage()
    {
        setSession([
            'header' => 'موجودی ناکافی',
            'type' => 'error',
            'message' => 'متاسفانه موجودی شما برای پرداخت این سفارش کافی نمی باشد.'
        ]);
        return back();
    }
}
