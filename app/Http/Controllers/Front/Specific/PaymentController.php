<?php

namespace App\Http\Controllers\Front\Specific;

use App\Events\OrderStatusChanged;
use App\Http\Helpers\Cart\Facade\Cart;
use App\Http\Helpers\Payment\PaymentInterface;
use App\Models\Specific\CartDetail;
use App\Models\Specific\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Payment\AsanPardakhtPayment;
use App\Http\Helpers\Payment\MellatPayment;

class PaymentController extends Controller
{

    public function pay(CartDetail $cartDetail)
    {
        if(!$cartDetail->pay_type_id){
            return $this->cartMustHavePayTypeMessage($cartDetail);
        }
        $this->checkIfCartBelongsToUser($cartDetail);
        try{
            $className=$cartDetail->payType->class_name;
            return (new $className())->payOrder($cartDetail);
        }catch (\Exception $e){
            setSession([
                'header'=>'خطا',
                'type'=>'error',
                'متاسفانه نوع پرداخت یافت نشد، لطفا بعدا مجددا امتحان نمایید.'
            ]);
            return back();
        }
    }

    public function result(Order $order)
    {
        $this->checkIfOrderBelongsToUser($order);
        $data=[
            'pageTitle'=>'نتیجه تراکنش',
            'order'=>$order
        ];
        return view('front.pages.payment.result',$data);
    }

    public function verifyOrder(Request $request)
    {
        return (new MellatPayment())->verifyOrder($request);
    }


    /**
     * @param CartDetail $cartDetail
     */
    protected function checkIfCartBelongsToUser(CartDetail $cartDetail)
    {
        if ($cartDetail->cart_id != Cart::get()->id) {
            abort(404);
        }
    }

    /**
     * @param Order $order
     */
    protected function checkIfOrderBelongsToUser(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            abort(404);
        }
    }

    /**
     * @param CartDetail $cartDetail
     * @return mixed
     */
    protected function cartMustHavePayTypeMessage(CartDetail $cartDetail)
    {
        setSession([
            'header' => 'اخطار',
            'type' => 'warning',
            'message' => 'قبل از ادامه می بایست یک روش پرداخت انتخاب نمایید.'
        ]);
        return redirect()->route('front.cart.step6',$cartDetail);
    }
}
