<?php

namespace App\Traits;

trait VisibilityTrait
{
    public function scopeVisible($query){
        if(self::class=="App\Models\Specific\Product"){
            return $query->where('products.display',1);
        }else{
            return $query->where('display',1);
        }

    }

    public function scopeInVisible($query){
        return $query->where('display',0);
    }
}