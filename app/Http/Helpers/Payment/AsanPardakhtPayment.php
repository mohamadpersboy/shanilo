<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 11/26/2018
 * Time: 11:42 AM
 */

namespace App\Http\Helpers\Payment;


use App\Models\Specific\CartDetail;
use App\Models\Specific\Plan;
use App\Models\Specific\SpecialSell;
use App\Models\Specific\SpecialSuggestion;

class AsanPardakhtPayment extends PaymentAbstract
{

    public function payOrder(CartDetail $cartDetail)
    {
        return $this->gateWayIsNotReadyMessage();
    }

    public function payFirstPageSpecialSuggestion(SpecialSuggestion $specialSuggestion,Plan $plan)
    {
        return $this->gateWayIsNotReadyMessage();
    }

    public function payFirstPageSpecialSell(SpecialSell $specialSell,Plan $plan)
    {
        return $this->gateWayIsNotReadyMessage();
    }

    public function verifyOrder(\Request $request)
    {
        // TODO: Implement verifyOrder() method.
    }

    public function verifyFirstPageSpecialSell(\Request $request)
    {
        // TODO: Implement verifyFirstPageSpecialSell() method.
    }

    public function verifyFirstPageSpecialSuggestion(\Request $request)
    {
        // TODO: Implement verifyFirstPageSpecialSuggestion() method.
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