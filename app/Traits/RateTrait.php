<?php
namespace App\Traits;
use App\Models\Base\Rate;

Trait RateTrait{
    public function rates()
    {
        return $this->morphMany(Rate::class,'rateable');
    }
}