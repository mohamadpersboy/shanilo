<?php

namespace App\Models\Specific;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class CreditLog extends Model
{
    const chargeType = 'charge';
    const requestCheckoutType = 'request checkout';
    const paymentType = 'payment';
    const shopCancelType = 'shop cancel';
    const customerCancelType = 'customer cancel';
    const increaseStatus = 'increase';
    const decreaseStatus = 'decrease';

    protected $fillable = ['price', 'status', 'type', 'user_id'];
    protected $table = 'credit_log';

}
