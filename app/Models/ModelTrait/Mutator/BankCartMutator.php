<?php

namespace App\Models\ModelTrait\Mutator;


trait BankCartMutator
{
    public function getFormatCartNoAttribute($value)
    {
        $num1 = substr($this->attributes['cart_no'], 0, 4);
        $num2 = substr($this->attributes['cart_no'], 4, 4);
        $num3 = substr($this->attributes['cart_no'], 8, 4);
        $num4 = substr($this->attributes['cart_no'], 12, 4);

        return $num4.' '.$num3.' '.$num2.' '.$num1;
    }
}
