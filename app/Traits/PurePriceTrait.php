<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 8/8/2018
 * Time: 11:08 AM
 */

namespace App\Traits;


trait PurePriceTrait
{
    public function getPurePriceAttribute()
    {
        $price= subPercent($this->price,$this->discount,true);
        $round=$price%1000;
        $price=$price-$round;
        if($round>0 && $round<500){
            $round=500;
        }elseif ($round>500 & $round<1000){
            $round=1000;
        }else{
            $round=0;
        }
        $price=$price+$round;
        return $price;
    }
}
