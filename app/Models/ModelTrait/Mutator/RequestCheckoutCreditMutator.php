<?php

namespace App\Models\ModelTrait\Mutator;


use Morilog\Jalali\jDate;

trait RequestCheckoutCreditMutator
{
    /**
     * Remove comma from  price
     *
     * @param $value
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = str_replace(',', '', $value);
    }

    /**
     * Set format jalali date for request_at
     *
     * @param $value
     * @return bool|string
     */
    public function getRequestAtAttribute($value)
    {
        if (!empty($value))
            return jDate::forge($value)->format('H:i:s Y-m-d');
        return '';
    }

    /**
     * Set format jalali date for done_at
     *
     * @param $value
     * @return bool|string
     */
    public function getDoneAtAttribute($value)
    {
        if (!empty($value))
            return jDate::forge($value)->format('H:i:s Y-m-d');
        return '';
    }

    /**
     * Set number format for price
     *
     * @param $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        if (!empty($value))
            return number_format($value);
        return '';
    }

    /**
     * Change Status
     *
     * @return string
     */
    public function getStatusRequestAttribute()
    {
        switch ($this->attributes['status']) {
            case 'pending';
                return 'در حال بررسی';
                break;
            case 'done':
                return 'تسویه ';
                break;
            case 'reject':
                return 'رد';
                break;
        }
    }
}
