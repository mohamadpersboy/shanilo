<?php

namespace App\Models\ModelTrait\Relation;


use App\Models\Base\User;
use App\Models\Specific\BankCart;

trait RequestCheckoutCreditRelation
{
    /**
     * Relation by User class
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * relation by bank cart
     *
     * @return mixed
     */
    public function bankCart()
    {
        return $this->belongsTo(BankCart::class,'bank_cart_id');
    }
}
