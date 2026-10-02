<?php

namespace App\Models\Specific;

use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Brand extends Model
{
    use SortableTrait,VisibilityTrait;

    protected $fillable=[
        'title',
        'display',
        'position'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function path()
    {
        request()->merge(['brand'=>$this->id]);
        $parameters=request()->only(['category','brand']);
        if(\Route::getCurrentRoute()->getName()=='front.shop.index'){
            return route('front.shop.index',$parameters);
        }else{
            return route('front.product.index',$parameters);
        }
    }
}
