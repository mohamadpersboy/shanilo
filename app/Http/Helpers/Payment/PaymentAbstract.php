<?php

namespace App\Http\Helpers\Payment;


use Illuminate\Http\Request;

abstract class PaymentAbstract implements PaymentInterface
{
    public abstract function verifyOrder(Request $request);

    public abstract function verifyFirstPageSpecialSell(Request $request);

    public abstract function verifyFirstPageSpecialSuggestion(Request $request);
}