<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 11/26/2018
 * Time: 11:25 AM
 */

namespace App\Http\Helpers\Payment;


use App\Models\Specific\CartDetail;
use App\Models\Specific\Plan;
use App\Models\Specific\SpecialSell;
use App\Models\Specific\SpecialSuggestion;


interface PaymentInterface
{
    public function payOrder(CartDetail $cartDetail);

    public function payFirstPageSpecialSuggestion(SpecialSuggestion $specialSuggestion,Plan $plan);

    public function payFirstPageSpecialSell(SpecialSell $specialSell,Plan $plan);


}