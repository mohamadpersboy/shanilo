<?php

namespace App\Models\Traits\Specific\Mutator;


use Morilog\Jalali\jDate;

trait CheckoutMutator
{
    /**
     * @return string
     */
    public function getFormatPriceAttribute()
    {
        return number_format($this->attributes['price']);
    }

    /**
     * @return string
     */
    public function getConditionCheckoutAttribute()
    {
        switch ($this->attributes['status']) {
            case 'done':
                return 'تسویه شد';
                break;
            case 'pending':
                return 'درحال بررسی';
                break;
            case 'denied':
                return 'رد شده';
                break;
        }
    }


    /**
     * @return bool|string
     */
    public function getCreatedJalaliAttribute()
    {
       return jDate::forge($this->attributes['created_at'])->format('H:s:i Y-m-d');
    }

    /**
     * @return bool|string
     */
    public function getUpdatedJalaliAttribute()
    {
        return jDate::forge($this->attributes['updated_at'])->format('H:s:i Y-m-d');
    }
}
