<?php


namespace App\Http\Helpers\Payment;

use App\Events\OrderStatusChanged;
use App\Models\Base\PayType;
use App\Models\Specific\CartDetail;
use App\Models\Specific\Order;
use App\Models\Specific\Plan;
use App\Models\Specific\SpecialSell;
use App\Models\Specific\SpecialSuggestion;
use function foo\func;
use Tohidplus\Mellat\Facades\Mellat;
use Tohidplus\Mellat\Models\MellatLog;
use Illuminate\Http\Request;

class MellatPayment extends PaymentAbstract
{
    public function payOrder(CartDetail $cartDetail)
    {
        $order = $cartDetail->transmit();
        Mellat::setCallbackUrl(route('front.payment.verifyOrder'));
        Mellat::set($order->payment->price, $order->id);
        return Mellat::redirect(function ($message) {
            setSession([
                'header' => 'خطا',
                'type' => 'error',
                'message' => $message
            ]);
            return back();
        });
    }

    public function payFirstPageSpecialSuggestion(SpecialSuggestion $specialSuggestion, Plan $plan)
    {
        Mellat::setCallBackUrl(route('front.profile.firstPageSpecialSuggestion.verify'));
        Mellat::set($plan->price);
        \Session::put('special_suggestion', $specialSuggestion->id);
        \Session::put('plan', $plan->id);
        return Mellat::redirect(function ($error) use ($specialSuggestion) {
            setSession([
                'header' => 'خطا از درگاه',
                'message' => $error,
                'type' => 'error'
            ]);
            return redirect()->route('front.profile.product.edit', $specialSuggestion->productDetail->product);
        });
    }

    public function payFirstPageSpecialSell(SpecialSell $specialSell, Plan $plan)
    {
        Mellat::setCallBackUrl(route('front.profile.firstPageSpecialSell.verify'));
        Mellat::set(100);
        \Session::put('special_sell', $specialSell->id);
        \Session::put('plan', $plan->id);
        return Mellat::redirect(function ($error) use ($specialSell) {
            setSession([
                'header' => 'خطا از درگاه',
                'message' => $error,
                'type' => 'error'
            ]);
            return redirect()->route('front.profile.product.edit', $specialSell->productDetail->product);
        });
    }

    public function verifyOrder(Request $request)
    {
        return Mellat::verify(function ($log) {
            $order = Order::find($log->order_id);
            $order->confirm();
            $order->payment->update(['status' => 'successful','ref_id'=>$log->ref_id]);
            event(new OrderStatusChanged($order));
            return redirect()->route('front.payment.result', $order);
        }, function ($log) {
            $order = Order::find($log->order_id);
            $order->payment->update(['status'=>'unsuccessful']);
            $order->update(['status'=>0]);
            return redirect()->route('front.payment.result', $order);
        });
    }

    public function verifyFirstPageSpecialSell(Request $request)
    {
        $specialSell = SpecialSell::find(\Session::get('special_sell'));
        $plan = Plan::find(\Session::get('plan'));
        $response = Mellat::verify(function ($log) use ($specialSell, $plan) {
            \request()->merge(['pay_type_id' => PayType::where('class_name', MellatPayment::class)->first()->id]);
            $paymentData = [
                'ref_id' => $log->ref_id,
            ];
            $firstPageSpecialSell = $specialSell->addToFirstPage($plan, $paymentData);
            $message = 'محصول شما تا زمان %expires_at% در بخش پیشنهادات ویژه صفحه اصلی وبسایت نمایش داده خواهد شد.';
            setSession([
                'header' => 'فروش ویژه صفحه اصلی وبسایت',
                'message' => str_replace('%expires_at%', ShowDate($firstPageSpecialSell->expires_at), $message),
                'type' => 'success',
            ], 'planOrdered');
            \Session::flash('payment', $firstPageSpecialSell->payment);
            return redirect()->route('front.profile.product.edit', $specialSell->productDetail->product);
        }, function ($log) use ($specialSell) {
            setSession([
                'header' => 'پرداخت نا موفق',
                'message' => $log->message,
                'type' => 'error'
            ]);
            return redirect()->route('front.profile.product.edit', $specialSell->productDetail->product);
        });
        \Session::forget('special_sell');
        \Session::forget('plan');
        return $response;
    }

    public function verifyFirstPageSpecialSuggestion(Request $request)
    {
        $specialSuggestion = SpecialSuggestion::find(\Session::get('special_suggestion'));
        $plan = Plan::find(\Session::get('plan'));
        $response = Mellat::verify(function ($log) use ($specialSuggestion, $plan) {
            \request()->merge(['pay_type_id' => PayType::where('class_name', MellatPayment::class)->first()->id]);
            $paymentData = [
                'ref_id' => $log->ref_id,
            ];
            $firstPageSpecialSuggestion = $specialSuggestion->addToFirstPage($plan, $paymentData);
            $message = 'محصول شما تا زمان %expires_at% در بخش پیشنهادات ویژه صفحه اصلی وبسایت نمایش داده خواهد شد.';
            setSession([
                'header' => 'پیشنهادات ویژه صفحه اصلی وبسایت',
                'message' => str_replace('%expires_at%', ShowDate($firstPageSpecialSuggestion->expires_at), $message),
                'type' => 'success',
            ], 'planOrdered');
            \Session::flash('payment', $firstPageSpecialSuggestion->payment);
            return redirect()->route('front.profile.product.edit', $specialSuggestion->productDetail->product);
        }, function ($log) use ($specialSuggestion) {
            setSession([
                'header' => 'پرداخت نا موفق',
                'message' => $log->message,
                'type' => 'error'
            ]);
            return redirect()->route('front.profile.product.edit', $specialSuggestion->productDetail->product);
        });
        \Session::forget('special_suggestion');
        \Session::forget('plan');
        return $response;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function gateWayIsNotReadyMessage()
    {
        setSession([
            'header' => 'اخطار',
            'type' => 'warning',
            'message' => 'با عرض پوزش در حال حاضر درگاه پرداخت سایت فعال نمی باشد.'
        ]);
        return back();
    }
}